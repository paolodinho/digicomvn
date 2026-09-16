from pathlib import Path

from PIL import Image, ImageEnhance, ImageFilter, ImageOps, ImageDraw, ImageFont


SOURCE = Path("../anh-chi-loan-goc/2aoboqyxgkpqnqyp2robpfwtt94ujixibba8agbo14.jpg")
OUTPUT = Path("preview-20-natural-clean.jpg")
COMPARE = Path("preview-20-before-after.jpg")


def soft_tone(image: Image.Image) -> Image.Image:
    image = ImageOps.exif_transpose(image).convert("RGB")

    # Gentle editorial correction: open shadows without flattening highlights.
    lut = []
    for value in range(256):
        normalized = value / 255.0
        corrected = normalized ** 0.94
        lut.append(max(0, min(255, round(corrected * 255))))
    image = image.point(lut * 3)

    # Keep the office scene neutral and skin tones restrained.
    r, g, b = image.split()
    r = r.point(lambda value: max(0, min(255, round(value * 1.012))))
    b = b.point(lambda value: max(0, min(255, round(value * 0.992))))
    image = Image.merge("RGB", (r, g, b))
    image = ImageEnhance.Contrast(image).enhance(1.045)
    image = ImageEnhance.Color(image).enhance(0.98)

    # Mild capture sharpening only; no facial reshaping or generative changes.
    image = image.filter(ImageFilter.UnsharpMask(radius=1.1, percent=62, threshold=4))
    return image


def make_comparison(before: Image.Image, after: Image.Image) -> Image.Image:
    max_height = 900
    panels = []
    for image in (before, after):
        panel = image.copy()
        panel.thumbnail((1600, max_height), Image.Resampling.LANCZOS)
        panels.append(panel)

    label_height = 56
    canvas = Image.new(
        "RGB",
        (panels[0].width + panels[1].width, max(p.height for p in panels) + label_height),
        "white",
    )
    canvas.paste(panels[0], (0, label_height))
    canvas.paste(panels[1], (panels[0].width, label_height))
    draw = ImageDraw.Draw(canvas)
    font = ImageFont.load_default(size=24)
    draw.text((20, 15), "TRUOC", fill="#111111", font=font)
    draw.text((panels[0].width + 20, 15), "BAN THU NATURAL & CLEAN", fill="#111111", font=font)
    return canvas


before = ImageOps.exif_transpose(Image.open(SOURCE)).convert("RGB")
after = soft_tone(before)
after.save(OUTPUT, quality=94, subsampling=0, optimize=True)
make_comparison(before, after).save(COMPARE, quality=92, subsampling=0, optimize=True)
