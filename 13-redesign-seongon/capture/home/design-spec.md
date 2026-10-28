# Design spec — https://seongon.com/
> Captured: 2026-10-28T00:21:11.734Z · slug: `home`

## DESKTOP (1440×900)

**Body:** Gilroy, sans-serif · 12px · line-height 17.9999px · color rgb(21, 21, 21) · bg rgba(0, 0, 0, 0)

### Màu chữ (color) — theo tần suất
`rgb(21, 21, 21)` ×2195  ·  `rgb(255, 255, 255)` ×261  ·  `rgb(0, 0, 0)` ×172  ·  `rgb(0, 74, 239)` ×102  ·  `rgb(7, 239, 156)` ×72  ·  `rgb(13, 83, 240)` ×57  ·  `rgb(102, 102, 102)` ×35  ·  `rgba(7, 239, 156, 0.2)` ×8  ·  `rgba(255, 255, 255, 0.2)` ×3  ·  `rgb(152, 152, 152)` ×3  ·  `rgb(68, 68, 68)` ×2  ·  `rgb(74, 222, 128)` ×1

### Màu nền (background)
`rgb(255, 255, 255)` ×269  ·  `rgb(13, 83, 240)` ×66  ·  `rgb(243, 243, 246)` ×38  ·  `rgb(243, 240, 248)` ×10  ·  `rgb(7, 239, 156)` ×6  ·  `rgb(0, 74, 239)` ×3  ·  `rgba(255, 255, 255, 0.15)` ×3  ·  `rgb(240, 252, 255)` ×2  ·  `rgba(0, 74, 239, 0.05)` ×2  ·  `rgba(255, 255, 255, 0.88)` ×1  ·  `rgba(0, 0, 0, 0.5)` ×1  ·  `rgba(0, 0, 0, 0.7)` ×1  ·  `rgba(255, 255, 255, 0.2)` ×1  ·  `rgba(13, 83, 240, 0.05)` ×1  ·  `rgb(0, 149, 242)` ×1  ·  `rgb(0, 60, 195)` ×1

### Gradient
- `linear-gradient(rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.25))`
- `linear-gradient(83deg, rgb(0, 53, 172), rgb(13, 83, 240))`

### Font family
- `Gilroy, sans-serif` ×2910
- `ui-sans-serif, system-ui, -apple-system, "system-ui", "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"` ×1

### Thang chữ (font-size có text)
13.5px(×183) · 15px(×98) · 12px(×68) · 30px(×32) · 36px(×31) · 54px(×27) · 18px(×24) · 10.5px(×14) · 48px(×7) · 24px(×6) · 192px(×4) · 39px(×3) · 72px(×3)

### Heading scale
- **h1**: 36px / 700 · Gilroy, sans-serif · lh 45px · ls normal · rgb(255, 255, 255)
- **h2**: 36px / 700 · Gilroy, sans-serif · lh 45px · ls normal · rgb(21, 21, 21)
- **h3**: 15px / 600 · Gilroy, sans-serif · lh 22.5001px · ls normal · rgb(21, 21, 21)

### Container max-width
1080px(×17) · 965.25px(×14) · 720px(×2) · 522.75px(×1) · 255px(×1) · 293.25px(×1) · 840px(×1) · 862.5px(×1)

### Border radius
15px(×283) · 12px(×188) · 9999px(×138) · 9px(×45) · 9999px 28.5px 9999px 9999px(×14) · 6.00005px 6.00005px 0px 0px(×7) · 18px(×7) · 0px 0px 2.99995px 2.99995px(×1)

### Box-shadow
- `rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0.04) 0px 8px 32px 0px`
- `rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(31, 34, 39, 0.08) 0px 8px 16px 0px`
- `rgb(255, 255, 255) 0px 0px 0px 0px, rgba(59, 130, 246, 0.5) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px`
- `rgba(0, 0, 0, 0.08) 4px 4px 32px 16px`
- `rgba(0, 0, 0, 0.04) 0px 4px 40px 0px`

### Hiệu ứng (transition / animation / keyframes)
- Phần tử có transition: **833** · có animation: **3** · pseudo trang trí (::before/::after): **32**
- Thời lượng transition hay dùng: 0.3s(×392) · 0.7s(×176) · 0.2s(×150) · 1s(×62) · 0.5s(×48) · 0.15s(×3) · 0.8s(×2) · 0.35s(×1)
- Transition mẫu:
  - `all 0.3s cubic-bezier(0.4, 0, 0.2, 1)` ×311
  - `transform 0.7s ease` ×176
  - `all 0.2s linear` ×150
  - `opacity, transform 1s ease` ×57
  - `all 0.3s ease-in-out` ×35
  - `all 0.5s ease-in-out` ×27
  - `opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1)` ×23
  - `all 0.3s ease` ×21
- Animation đang chạy:
  - `ring 1s` ×3
- @keyframes định nghĩa: `swiper-preloader-spin` · `fancybox-rotate` · `fancybox-dash` · `fancybox-fadeIn` · `fancybox-fadeOut` · `fancybox-zoomInUp` · `fancybox-zoomOutDown` · `fancybox-throwOutUp` · `fancybox-throwOutDown` · `spin` · `blink` · `pathMove` · `ring-chili` · `ring-food-footer` · `ring-food` · `fade-in-down` · `fade-in-left` · `ring` · `moveSwipeGesture` · `tracking-in-expand`

### Hoạ tiết / nền trang trí
- background-image (ảnh/SVG/gradient nền):
  - `url("data-uri…` ×1
- Pseudo trang trí (đường cong, chấm, vạch... vẽ bằng ::before/::after):
  - `div.img::before` ×23
  - `li.swiper-slide::before` ×3
  - `li.swiper-slide::after` ×3
  - `div.section-overview-capacity::before` ×1
  - `div.icon::before` ×1
  - `div.icon::after` ×1

### Component: Nút (button/CTA)
| Selector | Text | BG | Color | Radius | Padding | Shadow |
|---|---|---|---|---|---|---|
| `div.capacity-btn.flex-center` | Tải hồ sơ năng lực | rgba(0, 0, 0, 0) | rgb(21, 21, 21) | 0px | 0px | - |
| `a.btn.btn-primary` | Tải hồ sơ năng lực | rgb(255, 255, 255) | rgb(21, 21, 21) | 9999px | 6.00005px 21px 6.00005px 2.99995px | - |
| `button` | - | rgb(13, 83, 240) | rgb(255, 255, 255) | 0px | 0px | - |
| `div.swiper-button.button-prev` | 1 | rgba(0, 0, 0, 0) | rgb(255, 255, 255) | 0px | 0px | - |
| `div.swiper-button.button-next` | 2 | rgba(0, 0, 0, 0) | rgb(255, 255, 255) | 0px | 0px | - |
| `a.btn.btn-primary` | Tải Credential SEONGON | rgb(13, 83, 240) | rgb(21, 21, 21) | 9999px | 6.00005px 21px 6.00005px 2.99995px | - |

### Component: Card / thẻ
| Selector | Text | BG | Color | Radius | Padding | Shadow |
|---|---|---|---|---|---|---|
| `div.item.h-full` | diversity_4
							
				 | rgb(255, 255, 255) | rgb(21, 21, 21) | 15px | 18px | - |
| `li.swiper-slide.field-op-item` | Chess
									
								 | rgb(0, 149, 242) | rgb(21, 21, 21) | 15px | 0px | - |
| `li.swiper-slide.field-op-item` | rocket_launch
									
 | rgb(13, 83, 240) | rgb(21, 21, 21) | 15px | 0px | - |
| `li.swiper-slide.field-op-item` | diversity_4
									
		 | rgb(0, 60, 195) | rgb(21, 21, 21) | 15px | 0px | - |
| `div.box.bg-Primary-2` | GEO ENTERPRISE (Thiết kế | rgb(13, 83, 240) | rgb(255, 255, 255) | 15px | 21px | rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(31, 34, |
| `div.item.relative` | saved_search
						
				 | rgb(255, 255, 255) | rgb(21, 21, 21) | 15px | 21px | - |

### Sections (dải ngang, từ trên xuống)
| # | Phần tử | Top | Cao | Padding | Background | Ảnh |
|---|---|---|---|---|---|---|
| 1 | `section.home-1.section-swiper` | 61 | 720 | 0px | rgba(0, 0, 0, 0) | `desktop/01-home-1.png` |
| 2 | `section.home-2` | 781 | 948 | 0px | rgba(0, 0, 0, 0) | `desktop/02-home-2.png` |
| 3 | `section.home-3.section-py` | 1729 | 727 | 60px 0px | rgba(0, 0, 0, 0) | `desktop/03-home-3.png` |
| 4 | `section.home-4.section-py` | 2456 | 1015 | 60px 0px | rgb(240, 252, 255) | `desktop/04-home-4.png` |
| 5 | `section.section-global-partner.home-5` | 3471 | 1156 | 60px 0px | rgba(0, 0, 0, 0) | `desktop/05-section-global-partner.png` |
| 6 | `section.home-6` | 4627 | 1223 | 0px | rgba(0, 0, 0, 0) | `desktop/06-home-6.png` |
| 7 | `section.home-7.section-anim-3d` | 5850 | 543 | 60px 0px | rgb(13, 83, 240) | `desktop/07-home-7.png` |
| 8 | `section.home-8.section-anim-3d` | 6393 | 403 | 60px 0px 0px | rgba(0, 0, 0, 0) | `desktop/08-home-8.png` |
| 9 | `section.home-9.section-anim-3d` | 6797 | 699 | 60px 0px | rgba(0, 0, 0, 0) | `desktop/09-home-9.png` |
| 10 | `section.section-partner.section-py` | 7496 | 658 | 60px 0px | rgba(0, 0, 0, 0) | `desktop/10-section-partner.png` |
| 11 | `section.home-11` | 8153 | 819 | 0px | rgba(0, 0, 0, 0) | `desktop/11-home-11.png` |
| 12 | `section.home-12.section-py` | 8972 | 783 | 60px 0px | rgba(0, 0, 0, 0) | `desktop/12-home-12.png` |
| 13 | `section.home-13.section-py` | 9756 | 908 | 60px 0px | rgba(243, 243, 246, 0.4) | `desktop/13-home-13.png` |
| 14 | `div#contact-form.home-14` | 10664 | 619 | 0px | rgba(0, 0, 0, 0) | `desktop/14-contact-form.png` |

## MOBILE (390×844)

**Body:** Gilroy, sans-serif · 14.1666px · line-height 21.2499px · color rgb(21, 21, 21) · bg rgba(0, 0, 0, 0)

### Màu chữ (color) — theo tần suất
`rgb(21, 21, 21)` ×2034  ·  `rgb(255, 255, 255)` ×264  ·  `rgb(0, 0, 0)` ×162  ·  `rgb(0, 74, 239)` ×94  ·  `rgb(7, 239, 156)` ×64  ·  `rgb(13, 83, 240)` ×57  ·  `rgba(7, 239, 156, 0.2)` ×8  ·  `rgba(255, 255, 255, 0.2)` ×3  ·  `rgb(152, 152, 152)` ×3  ·  `rgb(68, 68, 68)` ×2  ·  `rgb(74, 222, 128)` ×1

### Màu nền (background)
`rgb(255, 255, 255)` ×254  ·  `rgb(13, 83, 240)` ×61  ·  `rgb(243, 243, 246)` ×34  ·  `rgb(243, 240, 248)` ×10  ·  `rgb(7, 239, 156)` ×6  ·  `rgb(0, 74, 239)` ×3  ·  `rgba(255, 255, 255, 0.15)` ×3  ·  `rgb(240, 252, 255)` ×2  ·  `rgba(0, 74, 239, 0.05)` ×2  ·  `rgba(255, 255, 255, 0.88)` ×1  ·  `rgba(0, 0, 0, 0.5)` ×1  ·  `rgba(0, 0, 0, 0.7)` ×1  ·  `rgba(255, 255, 255, 0.2)` ×1  ·  `rgba(13, 83, 240, 0.05)` ×1  ·  `rgb(0, 149, 242)` ×1  ·  `rgb(0, 60, 195)` ×1

### Gradient
- `linear-gradient(rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.25))`
- `linear-gradient(83deg, rgb(0, 53, 172), rgb(13, 83, 240))`

### Font family
- `Gilroy, sans-serif` ×2647
- `"Font Awesome 6 Pro"` ×21
- `"Material Symbols Outlined"` ×21
- `"Font Awesome 6 Brands"` ×2
- `ui-sans-serif, system-ui, -apple-system, "system-ui", "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"` ×1

### Thang chữ (font-size có text)
15.9375px(×137) · 16px(×68) · 14.1666px(×65) · 17.7084px(×36) · 31.875px(×27) · 28.3334px(×26) · 24.7916px(×23) · 14px(×14) · 56.6667px(×7) · 21.25px(×6) · 42.5px(×5) · 24px(×5) · 113.333px(×4) · 23.0208px(×3) · 51px(×3)

### Heading scale
- **h1**: 28.3334px / 700 · Gilroy, sans-serif · lh 35.4167px · ls normal · rgb(255, 255, 255)
- **h2**: 28.3334px / 700 · Gilroy, sans-serif · lh 36.8334px · ls normal · rgb(21, 21, 21)
- **h3**: 16px / 600 · Gilroy, sans-serif · lh 24px · ls normal · rgb(21, 21, 21)

### Container max-width
390px(×17) · 1139.53px(×14) · 850px(×2) · 301.042px(×1) · 991.667px(×1) · 1018.23px(×1) · 885.417px(×1) · 814.583px(×1)

### Border radius
17.7084px(×279) · 14.1666px(×176) · 9999px(×129) · 10.625px(×45) · 9999px 33.6458px 9999px 9999px(×14) · 21.25px(×7) · 0px 0px 3.54161px 3.54161px(×1)

### Box-shadow
- `rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0.04) 0px 8px 32px 0px`
- `rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(31, 34, 39, 0.08) 0px 8px 16px 0px`
- `rgb(255, 255, 255) 0px 0px 0px 0px, rgba(59, 130, 246, 0.5) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px`
- `rgba(0, 0, 0, 0.08) 4px 4px 32px 16px`
- `rgba(0, 0, 0, 0.04) 0px 4px 40px 0px`

### Hiệu ứng (transition / animation / keyframes)
- Phần tử có transition: **773** · có animation: **3** · pseudo trang trí (::before/::after): **32**
- Thời lượng transition hay dùng: 0.3s(×367) · 0.7s(×176) · 0.2s(×108) · 1s(×62) · 0.5s(×48) · 0.45s(×6) · 0.15s(×3) · 0.25s(×3)
- Transition mẫu:
  - `all 0.3s cubic-bezier(0.4, 0, 0.2, 1)` ×297
  - `transform 0.7s ease` ×176
  - `all 0.2s linear` ×108
  - `opacity, transform 1s ease` ×57
  - `all 0.5s ease-in-out` ×27
  - `all 0.3s ease-in-out` ×24
  - `opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1)` ×23
  - `all 0.3s ease` ×21
- Animation đang chạy:
  - `ring 1s` ×3
- @keyframes định nghĩa: `swiper-preloader-spin` · `fancybox-rotate` · `fancybox-dash` · `fancybox-fadeIn` · `fancybox-fadeOut` · `fancybox-zoomInUp` · `fancybox-zoomOutDown` · `fancybox-throwOutUp` · `fancybox-throwOutDown` · `spin` · `blink` · `pathMove` · `ring-chili` · `ring-food-footer` · `ring-food` · `fade-in-down` · `fade-in-left` · `ring` · `moveSwipeGesture` · `tracking-in-expand`

### Hoạ tiết / nền trang trí
- background-image (ảnh/SVG/gradient nền):
  - `url("data-uri…` ×1
- Pseudo trang trí (đường cong, chấm, vạch... vẽ bằng ::before/::after):
  - `div.img::before` ×23
  - `li.swiper-slide::before` ×3
  - `li.swiper-slide::after` ×3
  - `div.section-overview-capacity::before` ×1
  - `div.icon::before` ×1
  - `div.icon::after` ×1

### Component: Nút (button/CTA)
| Selector | Text | BG | Color | Radius | Padding | Shadow |
|---|---|---|---|---|---|---|
| `button` | - | rgb(13, 83, 240) | rgb(255, 255, 255) | 0px | 0px | - |
| `div.swiper-button.button-prev` | 1 | rgba(0, 0, 0, 0) | rgb(255, 255, 255) | 0px | 0px | - |
| `div.swiper-button.button-next` | 2 | rgba(0, 0, 0, 0) | rgb(255, 255, 255) | 0px | 0px | - |
| `a.btn.btn-primary` | Tải Credential SEONGON | rgb(13, 83, 240) | rgb(21, 21, 21) | 9999px | 7.08339px 24.7916px 7.08339px 3.54161px | - |
| `div.button-more.flex` | Tìm hiểu thêm | rgba(0, 0, 0, 0) | rgb(255, 255, 255) | 0px | 0px | - |
| `a.btn.btn-primary` | Tìm hiểu thêm | rgba(0, 0, 0, 0) | rgb(255, 255, 255) | 9999px | 7.08339px 0px 7.08339px 3.54161px | - |

### Component: Card / thẻ
| Selector | Text | BG | Color | Radius | Padding | Shadow |
|---|---|---|---|---|---|---|
| `div.item.h-full` | diversity_4
							
				 | rgb(255, 255, 255) | rgb(21, 21, 21) | 17.7084px | 14.1666px | - |
| `li.swiper-slide.field-op-item` | Chess
									
								 | rgb(0, 149, 242) | rgb(21, 21, 21) | 17.7084px | 0px | - |
| `li.swiper-slide.field-op-item` | rocket_launch
									
 | rgb(13, 83, 240) | rgb(21, 21, 21) | 17.7084px | 0px | - |
| `li.swiper-slide.field-op-item` | diversity_4
									
		 | rgb(0, 60, 195) | rgb(21, 21, 21) | 17.7084px | 0px | - |
| `div.box.bg-Primary-2` | GEO ENTERPRISE (Thiết kế | rgb(13, 83, 240) | rgb(255, 255, 255) | 17.7084px | 10.625px | rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(31, 34, |
| `div.item.relative` | saved_search
						
				 | rgb(255, 255, 255) | rgb(21, 21, 21) | 17.7084px | 24.7916px | - |

### Sections (dải ngang, từ trên xuống)
| # | Phần tử | Top | Cao | Padding | Background | Ảnh |
|---|---|---|---|---|---|---|
| 1 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/01-swiper-slide.png` |
| 2 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/02-swiper-slide.png` |
| 3 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/03-swiper-slide.png` |
| 4 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/04-swiper-slide.png` |
| 5 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/05-swiper-slide.png` |
| 6 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/06-swiper-slide.png` |
| 7 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/07-swiper-slide.png` |
| 8 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/08-swiper-slide.png` |
| 9 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/09-swiper-slide.png` |
| 10 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/10-swiper-slide.png` |
| 11 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/11-swiper-slide.png` |
| 12 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/12-swiper-slide.png` |
| 13 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/13-swiper-slide.png` |
| 14 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/14-swiper-slide.png` |
| 15 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/15-swiper-slide.png` |
| 16 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/16-swiper-slide.png` |
| 17 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/17-swiper-slide.png` |
| 18 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/18-swiper-slide.png` |
| 19 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/19-swiper-slide.png` |
| 20 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/20-swiper-slide.png` |
| 21 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/21-swiper-slide.png` |
| 22 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/22-swiper-slide.png` |
| 23 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/23-swiper-slide.png` |
| 24 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/24-swiper-slide.png` |
| 25 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/25-swiper-slide.png` |
| 26 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/26-swiper-slide.png` |
| 27 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/27-swiper-slide.png` |
| 28 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/28-swiper-slide.png` |
| 29 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/29-swiper-slide.png` |
| 30 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/30-swiper-slide.png` |
| 31 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/31-swiper-slide.png` |
| 32 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/32-swiper-slide.png` |
| 33 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/33-swiper-slide.png` |
| 34 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/34-swiper-slide.png` |
| 35 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/35-swiper-slide.png` |
| 36 | `div.swiper-slide` | 5703 | 98 | 3.54161px | rgb(255, 255, 255) | `mobile/36-swiper-slide.png` |

---
Ảnh full + từng section nằm trong thư mục `desktop/` và `mobile/`. Mở `design-spec.json` để lấy số liệu thô.