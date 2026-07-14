# -*- coding: utf-8 -*-
# Bo illustration SVG flat style Digicom. viewBox 0 0 600 540.
# Palette
NAVY="#1C2035"; BLUE="#4761FF"; BLUEM="#7C93F5"; BLUEL="#AEC0FF"; BLUELL="#DCE4FF"
TEAL="#12B39C"; TEALL="#8CD9CC"; WHITE="#FFFFFF"; PINK="#F3B7C8"; YEL="#FFD666"; GREEN="#8FD0A9"

def wrap(inner, blob=True):
    b = f'<path d="M120 300 C60 190 180 70 320 78 C470 86 560 160 548 300 C538 420 430 490 300 480 C180 471 175 405 120 300 Z" fill="#E7EEFF"/>' if blob else ''
    return (f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 540" fill="none">'
            f'{b}<ellipse cx="300" cy="486" rx="196" ry="20" fill="#CBD7FA" opacity=".55"/>'
            f'{inner}</svg>')

# 1. SEO / ranking: bar chart tang + kinh lup
SEO = wrap(f'''
<rect x="176" y="300" width="60" height="120" rx="12" fill="{BLUEL}"/>
<rect x="250" y="250" width="60" height="170" rx="12" fill="{BLUEM}"/>
<rect x="324" y="196" width="60" height="224" rx="12" fill="{BLUE}"/>
<path d="M196 250 L280 205 L360 150" stroke="{NAVY}" stroke-width="8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
<circle cx="196" cy="250" r="12" fill="{TEAL}"/><circle cx="280" cy="205" r="12" fill="{TEAL}"/>
<path d="M330 150 L360 150 L360 180" stroke="{NAVY}" stroke-width="8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
<circle cx="392" cy="300" r="66" fill="{WHITE}" stroke="{NAVY}" stroke-width="10"/>
<circle cx="392" cy="300" r="40" fill="{TEALL}" opacity=".6"/>
<path d="M438 346 L470 378" stroke="{NAVY}" stroke-width="14" stroke-linecap="round"/>
<circle cx="150" cy="150" r="14" fill="{YEL}"/><circle cx="452" cy="180" r="10" fill="{PINK}"/>''')

# 2. Backlink: cac node noi mat xich
BACKLINK = wrap(f'''
<line x1="220" y1="200" x2="330" y2="300" stroke="{BLUEM}" stroke-width="8"/>
<line x1="330" y1="300" x2="250" y2="400" stroke="{BLUEM}" stroke-width="8"/>
<line x1="330" y1="300" x2="430" y2="220" stroke="{BLUEM}" stroke-width="8"/>
<line x1="330" y1="300" x2="420" y2="400" stroke="{BLUEM}" stroke-width="8"/>
<circle cx="330" cy="300" r="50" fill="{BLUE}"/>
<path d="M312 300 a18 18 0 0 1 18-18 h8 a18 18 0 0 1 0 36 M348 300 a18 18 0 0 1 -18 18 h-8 a18 18 0 0 1 0-36" stroke="{WHITE}" stroke-width="7" fill="none" stroke-linecap="round"/>
<circle cx="220" cy="200" r="30" fill="{TEAL}"/><circle cx="250" cy="400" r="30" fill="{BLUEL}"/>
<circle cx="430" cy="220" r="30" fill="{BLUEL}"/><circle cx="420" cy="400" r="30" fill="{TEAL}"/>
<circle cx="150" cy="300" r="12" fill="{YEL}"/><circle cx="470" cy="150" r="10" fill="{PINK}"/>''')

# 3. Guest Post / content: tai lieu + but
CONTENT = wrap(f'''
<rect x="200" y="150" width="200" height="256" rx="16" fill="{WHITE}" stroke="{NAVY}" stroke-width="8"/>
<rect x="230" y="192" width="140" height="14" rx="7" fill="{BLUE}"/>
<rect x="230" y="226" width="140" height="12" rx="6" fill="{BLUEL}"/>
<rect x="230" y="256" width="110" height="12" rx="6" fill="{BLUEL}"/>
<rect x="230" y="286" width="140" height="12" rx="6" fill="{BLUEL}"/>
<rect x="230" y="316" width="90" height="12" rx="6" fill="{BLUEL}"/>
<path d="M356 360 l70 -70 a20 20 0 0 1 28 28 l-70 70 l-38 10 z" fill="{TEAL}" stroke="{NAVY}" stroke-width="7" stroke-linejoin="round"/>
<circle cx="176" cy="180" r="12" fill="{YEL}"/><circle cx="440" cy="180" r="10" fill="{PINK}"/>''')

# 4. Textlink: doan van co link highlight + anchor
TEXTLINK = wrap(f'''
<rect x="180" y="170" width="240" height="220" rx="18" fill="{WHITE}" stroke="{NAVY}" stroke-width="8"/>
<rect x="210" y="206" width="180" height="12" rx="6" fill="{BLUEL}"/>
<rect x="210" y="234" width="180" height="12" rx="6" fill="{BLUEL}"/>
<rect x="210" y="270" width="120" height="18" rx="9" fill="{BLUE}"/>
<line x1="210" y1="292" x2="330" y2="292" stroke="{BLUE}" stroke-width="4"/>
<rect x="210" y="316" width="180" height="12" rx="6" fill="{BLUEL}"/>
<rect x="210" y="344" width="140" height="12" rx="6" fill="{BLUEL}"/>
<g transform="translate(360 356)"><circle r="40" fill="{TEAL}"/>
<path d="M-16 0 a14 14 0 0 1 14-14 h8 a14 14 0 0 1 0 28 M16 0 a14 14 0 0 1 -14 14 h-8 a14 14 0 0 1 0-28" stroke="{WHITE}" stroke-width="6" fill="none" stroke-linecap="round"/></g>
<circle cx="160" cy="200" r="12" fill="{YEL}"/><circle cx="452" cy="200" r="10" fill="{PINK}"/>''')

# 5. Booking PR: loa + song phat + newspaper
PR = wrap(f'''
<rect x="300" y="250" width="150" height="150" rx="16" fill="{WHITE}" stroke="{NAVY}" stroke-width="8"/>
<rect x="322" y="278" width="60" height="44" rx="6" fill="{BLUEL}"/>
<rect x="322" y="336" width="106" height="10" rx="5" fill="{BLUEL}"/>
<rect x="322" y="358" width="80" height="10" rx="5" fill="{BLUEL}"/>
<path d="M150 300 l86 -34 v128 l-86 -34 z" fill="{BLUE}" stroke="{NAVY}" stroke-width="7" stroke-linejoin="round"/>
<rect x="120" y="286" width="34" height="60" rx="8" fill="{BLUE}" stroke="{NAVY}" stroke-width="7"/>
<path d="M236 250 l40 -18 v192 l-40 -18 z" fill="{TEAL}" stroke="{NAVY}" stroke-width="7" stroke-linejoin="round"/>
<path d="M300 250 q40 50 0 100" stroke="{TEAL}" stroke-width="8" fill="none" stroke-linecap="round"/>
<path d="M330 232 q56 68 0 136" stroke="{TEALL}" stroke-width="8" fill="none" stroke-linecap="round"/>
<circle cx="180" cy="180" r="12" fill="{YEL}"/><circle cx="470" cy="200" r="10" fill="{PINK}"/>''')

# 6. Analytics / traffic: man hinh line graph + pie
ANALYTICS = wrap(f'''
<rect x="176" y="164" width="248" height="196" rx="16" fill="{WHITE}" stroke="{NAVY}" stroke-width="8"/>
<path d="M200 320 L240 280 L280 300 L320 236 L360 258 L400 200" stroke="{BLUE}" stroke-width="8" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
<circle cx="320" cy="236" r="9" fill="{TEAL}"/><circle cx="400" cy="200" r="9" fill="{TEAL}"/>
<line x1="200" y1="345" x2="400" y2="345" stroke="{BLUEL}" stroke-width="5"/>
<rect x="250" y="360" width="100" height="14" rx="7" fill="{BLUEL}"/>
<rect x="270" y="376" width="60" height="52" rx="6" fill="{BLUEM}"/>
<g transform="translate(408 392)"><circle r="46" fill="{BLUEL}"/>
<path d="M0 0 L0 -46 A46 46 0 0 1 40 23 Z" fill="{TEAL}"/>
<path d="M0 0 L40 23 A46 46 0 0 1 -20 41 Z" fill="{BLUE}"/></g>
<circle cx="160" cy="180" r="12" fill="{YEL}"/><circle cx="452" cy="170" r="10" fill="{PINK}"/>''')

# 7. Local SEO: ban do + ghim + globe
LOCAL = wrap(f'''
<rect x="180" y="180" width="240" height="200" rx="18" fill="{WHITE}" stroke="{NAVY}" stroke-width="8"/>
<path d="M180 300 L250 260 L320 300 L390 250" stroke="{BLUEL}" stroke-width="8" fill="none" stroke-linecap="round"/>
<path d="M210 380 L270 340 L340 372" stroke="{BLUEL}" stroke-width="8" fill="none" stroke-linecap="round"/>
<path d="M330 210 c-40 0 -66 30 -66 66 c0 48 66 104 66 104 c0 0 66 -56 66 -104 c0 -36 -26 -66 -66 -66 z" fill="{BLUE}" stroke="{NAVY}" stroke-width="7"/>
<circle cx="330" cy="278" r="24" fill="{WHITE}"/>
<circle cx="150" cy="200" r="26" fill="{TEAL}"/><path d="M132 200 h36 M150 182 v36" stroke="{WHITE}" stroke-width="5"/>
<circle cx="470" cy="200" r="10" fill="{PINK}"/><circle cx="170" cy="360" r="12" fill="{YEL}"/>''')

# 8. Tools / technical: banh rang + man hinh
TECH = wrap(f'''
<rect x="180" y="180" width="230" height="180" rx="16" fill="{WHITE}" stroke="{NAVY}" stroke-width="8"/>
<rect x="205" y="210" width="60" height="60" rx="8" fill="{BLUEL}"/>
<rect x="285" y="210" width="100" height="14" rx="7" fill="{BLUE}"/>
<rect x="285" y="238" width="80" height="12" rx="6" fill="{BLUEL}"/>
<rect x="205" y="292" width="180" height="12" rx="6" fill="{BLUEL}"/>
<rect x="205" y="318" width="120" height="12" rx="6" fill="{BLUEL}"/>
<g transform="translate(410 360)"><path d="M0 -54 l14 8 a44 44 0 0 1 12 0 l14 -8 l14 24 l-10 12 a44 44 0 0 1 -6 10 l2 16 l-24 14 l-12 -10 a44 44 0 0 1 -12 0 l-12 10 l-24 -14 l2 -16 a44 44 0 0 1 -6 -10 l-10 -12 z" fill="{TEAL}" stroke="{NAVY}" stroke-width="6" stroke-linejoin="round"/><circle r="18" fill="{WHITE}" stroke="{NAVY}" stroke-width="6"/></g>
<circle cx="160" cy="190" r="12" fill="{YEL}"/><circle cx="450" cy="180" r="10" fill="{PINK}"/>''')

# 9. Keyword / research: kinh lup + tu khoa list
KEYWORD = wrap(f'''
<rect x="180" y="176" width="210" height="210" rx="16" fill="{WHITE}" stroke="{NAVY}" stroke-width="8"/>
<rect x="206" y="210" width="120" height="14" rx="7" fill="{BLUE}"/>
<rect x="206" y="242" width="158" height="12" rx="6" fill="{BLUEL}"/>
<rect x="206" y="270" width="130" height="12" rx="6" fill="{BLUEL}"/>
<rect x="206" y="298" width="158" height="12" rx="6" fill="{BLUEL}"/>
<rect x="206" y="326" width="100" height="12" rx="6" fill="{BLUEL}"/>
<circle cx="392" cy="356" r="58" fill="{WHITE}" stroke="{NAVY}" stroke-width="10"/>
<circle cx="392" cy="356" r="34" fill="{TEALL}" opacity=".6"/>
<path d="M434 398 L468 432" stroke="{NAVY}" stroke-width="13" stroke-linecap="round"/>
<circle cx="160" cy="200" r="12" fill="{YEL}"/><circle cx="452" cy="190" r="10" fill="{PINK}"/>''')

# 10. Idea / strategy: bong den + banh rang nho
IDEA = wrap(f'''
<path d="M300 170 c-58 0 -100 44 -100 100 c0 40 22 66 44 86 c10 9 14 18 14 30 h84 c0 -12 4 -21 14 -30 c22 -20 44 -46 44 -86 c0 -56 -42 -100 -100 -100 z" fill="{YEL}" stroke="{NAVY}" stroke-width="8"/>
<path d="M262 262 c8 -22 30 -34 52 -30" stroke="{WHITE}" stroke-width="8" fill="none" stroke-linecap="round"/>
<rect x="266" y="392" width="68" height="16" rx="8" fill="{NAVY}"/>
<rect x="274" y="414" width="52" height="14" rx="7" fill="{NAVY}"/>
<path d="M300 150 v-24 M370 178 l18 -18 M230 178 l-18 -18 M410 260 h24 M166 260 h24" stroke="{TEAL}" stroke-width="8" stroke-linecap="round"/>
<circle cx="160" cy="330" r="12" fill="{BLUE}"/><circle cx="452" cy="330" r="10" fill="{PINK}"/>''')

LIB = {"SEO":SEO,"BACKLINK":BACKLINK,"CONTENT":CONTENT,"TEXTLINK":TEXTLINK,
       "PR":PR,"ANALYTICS":ANALYTICS,"LOCAL":LOCAL,"TECH":TECH,"KEYWORD":KEYWORD,"IDEA":IDEA}
