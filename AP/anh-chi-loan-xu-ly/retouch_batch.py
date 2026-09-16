from pathlib import Path

import numpy as np
from PIL import Image, ImageEnhance, ImageFilter, ImageOps, ImageDraw, ImageFont


SOURCE_DIR = Path("../anh-chi-loan-goc")
OUTPUT_DIR = Path("full-resolution")
CONTACT_SHEET = Path("contact-sheet-retouched.jpg")


def natural_clean(image: Image.Image) -> Image.Image:
    image = ImageOps.exif_transpose(image).convert("RGB")
    array = np.asarray(image).astype(np.float32) / 255.0

    # Restrained grey-world balance to reduce room/window colour casts.
    channel_means = array.reshape(-1, 3).mean(axis=0)
    neutral = float(channel_means.mean())
    gains = np.clip(neutral / np.maximum(channel_means, 1e-6), 0.97, 1.03)
    array = np.clip(array * gains.reshape(1, 1, 3), 0.0, 1.0)

    # Per-frame shadow recovery. Limits keep window highlights and skin natural.
    luminance = 0.2126 * array[:, :, 0] + 0.7152 * array[:, :, 1] + 0.0722 * array[:, :, 2]
    median = float(np.median(luminance))
    gamma = float(np.clip(np.log(0.49) / np.log(max(median, 0.05)), 0.88, 1.035))
    array = np.power(array, gamma)

    result = Image.fromarray(np.uint8(np.clip(array * 255.0 + 0.5, 0, 255)), "RGB")
    result = ImageEnhance.Contrast(result).enhance(1.035)
    result = ImageEnhance.Color(result).enhance(0.985)

    # Capture sharpening only—no face reshaping, artificial skin or generative edits.
    result = result.filter(ImageFilter.UnsharpMask(radius=1.05, percent=58, threshold=4))
    return result


def make_contact_sheet(files: list[Path]) -> None:
    font = ImageFont.load_default(size=20)
    cells = []
    for index, path in enumerate(files, 1):
        image = Image.open(path).convert("RGB")
        image.thumbnail((320, 250), Image.Resampling.LANCZOS)
        cell = Image.new("RGB", (350, 300), "#f3f3f3")
        cell.paste(image, ((350 - image.width) // 2, 8 + (250 - image.height) // 2))
        ImageDraw.Draw(cell).text((14, 268), f"{index:02d}", fill="#111111", font=font)
        cells.append(cell)

    columns = 4
    rows = (len(cells) + columns - 1) // columns
    sheet = Image.new("RGB", (columns * 350, rows * 300), "white")
    for index, cell in enumerate(cells):
        sheet.paste(cell, ((index % columns) * 350, (index // columns) * 300))
    sheet.save(CONTACT_SHEET, quality=92, optimize=True)


OUTPUT_DIR.mkdir(parents=True, exist_ok=True)
outputs = []
for index, source in enumerate(sorted(SOURCE_DIR.glob("*.jpg")), 1):
    destination = OUTPUT_DIR / f"chi-loan-{index:02d}-retouch.jpg"
    original = Image.open(source)
    edited = natural_clean(original)
    edited.save(destination, quality=95, subsampling=0, optimize=True, dpi=original.info.get("dpi", (72, 72)))
    outputs.append(destination)

make_contact_sheet(outputs)
print(f"Retouched {len(outputs)} full-resolution photos into {OUTPUT_DIR.resolve()}")
