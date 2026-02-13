# 🎨 PANDUAN KUSTOMISASI LENGKAP

## Ar Creative - Professional Portfolio Website

**Status:** ✅ Updated v1.1  
**Fitur Baru:** Hamburger menu + Scroll to Top button

---

## 📋 Apa yang Sudah Diupdate

✅ **Hamburger Menu** - Garis animasi saat diklik (mobile)  
✅ **Menu Dropdown** - Muncul dari atas dengan smooth animation  
✅ **Responsive Mobile** - Ukuran optimal untuk handphone  
✅ **Scroll to Top Button** - Tombol di kanan bawah untuk naik ke atas

---

## 🎯 Area-Area yang Perlu Dikustomisasi

Berikut adalah bagian-bagian website yang HARUS Anda ganti dengan gambar dan konten Anda sendiri:

---

## 1️⃣ **HERO IMAGE SECTION** ⭐ PENTING

### Lokasi di Website:

```
Bagian atas website (setelah navbar)
Gambar besar di sebelah kanan teks "Graphic Designer & Web Developer"
```

### File yang Perlu Diubah:

📄 `index.html` - Baris 84-93

### Kode Saat Ini:

```html
<div class="hero-image">
  <div class="hero-image-placeholder">
    <i class="fas fa-user-tie"></i>
  </div>
</div>
```

### Cara Menggantinya:

**Pilihan 1: Ganti dengan foto nyata**

```html
<div class="hero-image">
  <img
    src="img/profile-photo.jpg"
    alt="Ar Creative Profile"
    style="width: 100%; max-width: 400px; border-radius: 20px; 
              box-shadow: 0 20px 60px rgba(255, 107, 53, 0.2);"
  />
</div>
```

**Pilihan 2: Ganti dengan icon berbeda**

```html
<div class="hero-image">
  <div class="hero-image-placeholder">
    <i class="fas fa-laptop-code"></i>
    <!-- atau icon lain -->
  </div>
</div>
```

### Font Awesome Icons Pilihan:

- `fa-user-tie` - Default (profile)
- `fa-laptop-code` - Coding developer
- `fa-pencil-ruler` - Design
- `fa-chart-line` - Business
- `fa-code` - Web development

---

## 2️⃣ **ABOUT SECTION IMAGE**

### Lokasi di Website:

```
Scroll ke bawah, bagian "About Me"
Gambar di sebelah kiri teks bio
```

### File yang Perlu Diubah:

📄 `index.html` - Baris 103-105

### Kode Saat Ini:

```html
<div class="about-image">
  <img src="img/placeholder-profile.jpg" alt="Ar Creative" />
</div>
```

### Cara Menggantinya:

```html
<div class="about-image">
  <img src="img/your-photo.jpg" alt="Ar Creative" />
</div>
```

### Catatan:

- Ganti `img/placeholder-profile.jpg` dengan path file gambar Anda
- Pastikan file ada di folder `img/`
- Rekomendasikan ukuran: 400x400px atau lebih

---

## 3️⃣ **PORTFOLIO ITEMS** (4 Gambar)

### Lokasi di Website:

```
Scroll ke section "Portfolio"
Grid dengan 4 item work samples
```

### File yang Perlu Diubah:

📄 `index.html` - Baris 285-325

### Kode Saat Ini:

```html
<div class="portfolio-item" data-category="design">
  <img src="img/placeholder-portfolio.jpg" alt="Brand Identity Design" />
  <div class="overlay">
    <h3>Brand Identity Design</h3>
  </div>
</div>
```

### Cara Menggantinya:

**Struktur Portfolio Item:**

```html
<div class="portfolio-item" data-category="design">
  <img src="img/portfolio-design-1.jpg" alt="Nama Project" />
  <div class="overlay">
    <h3>Nama Project</h3>
  </div>
</div>
```

**Category Options:**

- `data-category="design"` - Untuk Graphic Design
- `data-category="web"` - Untuk Web Development

**Contoh Lengkap (4 item):**

```html
<!-- Design Project -->
<div class="portfolio-item" data-category="design">
  <img src="img/logo-design.jpg" alt="Logo Design Client A" />
  <div class="overlay">
    <h3>Logo Design - Client A</h3>
  </div>
</div>

<!-- Web Project -->
<div class="portfolio-item" data-category="web">
  <img src="img/website-portfolio.jpg" alt="E-Commerce Website" />
  <div class="overlay">
    <h3>E-Commerce Website</h3>
  </div>
</div>

<!-- Design Project -->
<div class="portfolio-item" data-category="design">
  <img src="img/banner-design.jpg" alt="Banner Design" />
  <div class="overlay">
    <h3>Social Media Banner</h3>
  </div>
</div>

<!-- Web Project -->
<div class="portfolio-item" data-category="web">
  <img src="img/website-app.jpg" alt="Web App Development" />
  <div class="overlay">
    <h3>Web App Development</h3>
  </div>
</div>
```

---

## 4️⃣ **WARNA & BRANDING**

### Lokasi: CSS Variables

### File yang Perlu Diubah:

📄 `css/style.css` - Baris 13-19

### Warna Saat Ini:

```css
:root {
  --primary-color: #ff6b35; /* Orange - warna utama */
  --secondary-color: #004e89; /* Dark Blue */
  --dark-bg: #0f1419; /* Background gelap */
  --dark-bg2: #1a1f2e; /* Bg section lebih terang */
  --text-light: #e0e0e0; /* Warna teks */
  --text-lighter: #b0b0b0; /* Teks lebih terang */
  --border-color: #333; /* Border */
}
```

### Cara Menggantinya:

```css
:root {
  --primary-color: #ff5733; /* Ganti dengan warna brand Anda */
  --secondary-color: #003d99; /* Ganti secondary color */
  /* Sisanya bisa tetap sama */
}
```

### Color Palette Suggestions:

**Purple Theme:**

```css
--primary-color: #8b5cf6;
--secondary-color: #5b21b6;
```

**Green Theme:**

```css
--primary-color: #10b981;
--secondary-color: #047857;
```

**Blue Theme:**

```css
--primary-color: #3b82f6;
--secondary-color: #1e40af;
```

---

## 5️⃣ **TEXT CONTENT** (Paling Penting!)

### File yang Perlu Diubah:

📄 `index.html` - Multiple locations

### Area-Area Text:

#### A. HERO TITLE & SUBTITLE

**Lokasi:** Baris 62-70

```html
<p class="hero-subtitle">I AM AR CREATIVE</p>
<h1 class="hero-title">
  Graphic Designer <span class="text-orange">&</span><br />
  Web Developer
</h1>
<p class="hero-description">
  Solusi digital lengkap: desain grafis, web development, ...
</p>
```

**Ganti menjadi:**

```html
<p class="hero-subtitle">I AM [NAMA ANDA]</p>
<h1 class="hero-title">
  [PROFESI 1] <span class="text-orange">&</span><br />
  [PROFESI 2]
</h1>
<p class="hero-description">[Deskripsi singkat tentang layanan Anda]</p>
```

#### B. ABOUT ME SECTION

**Lokasi:** Baris 110-125

```html
<h3>About Ar Creative</h3>
<p>Saya adalah seorang profesional di bidang...</p>
```

**Ganti dengan bio Anda sendiri**

#### C. SERVICES

**Lokasi:** Baris 330-395
Berisi 6 service cards dengan:

- Icon
- Judul service
- Deskripsi
- Pricing

#### D. SKILL NAMES (dalam Chart)

**Lokasi:** Baris 409-420

```javascript
labels: [
  "Design Grafis (90%)",
  "CMS Web Dev (80%)",
  "Content Management (78%)",
  "IT Support (85%)",
],
```

---

## 6️⃣ **CONTACT INFORMATION**

### File yang Perlu Diubah:

📄 `index.html` - Baris 500-540

### Current Contact Info:

```html
<p><strong>WhatsApp Personal:</strong> +62 812-4861-6454</p>
<p><strong>WhatsApp Bisnis:</strong> +62 821-9854-9129</p>
<p><strong>Email:</strong> suportarcreative@gmail.com</p>
```

### Cara Menggantinya:

```html
<p><strong>WhatsApp:</strong> +62 [NOMOR ANDA]</p>
<p><strong>Email:</strong> [EMAIL ANDA]</p>
<p><strong>Instagram:</strong> @[INSTAGRAM ANDA]</p>
```

### Social Media Links (Footer)

**Lokasi:** Baris 580-590

```html
<a href="https://instagram.com/arcreative_26" target="_blank">
  <i class="fab fa-instagram"></i>
</a>
```

**Ganti link dengan social media Anda**

---

## 7️⃣ **LOGO / BRAND NAME**

### File yang Perlu Diubah:

📄 `index.html` - Baris 36

### Current:

```html
<a href="#home" class="logo">Ar Creative</a>
```

### Ganti menjadi:

```html
<a href="#home" class="logo">[NAMA BRAND ANDA]</a>
```

---

## 8️⃣ **FAVICON & TITLE**

### File yang Perlu Diubah:

📄 `index.html` - Baris 6-7

### Current:

```html
<title>Ar Creative - Portfolio | Graphic Designer & Web Developer</title>
```

### Ganti menjadi:

```html
<title>[NAMA ANDA] - Portfolio | [PROFESI]</title>
```

---

## 🎯 FILE STRUCTURE UNTUK GAMBAR

Buat folder dan file gambar di lokasi:

```
arcreative/img/
├── profile-photo.jpg          (untuk hero section)
├── about-photo.jpg            (untuk about section)
├── portfolio-design-1.jpg     (portfolio item 1)
├── portfolio-web-1.jpg        (portfolio item 2)
├── portfolio-design-2.jpg     (portfolio item 3)
├── portfolio-web-2.jpg        (portfolio item 4)
└── (gambar lain sesuai kebutuhan)
```

---

## ✅ CHECKLIST KUSTOMISASI

Sebelum launch, pastikan sudah mengubah:

### Content (HTML - index.html):

- [ ] Hero title (nama Anda & profesi)
- [ ] Hero description
- [ ] About Me text (bio)
- [ ] Services (judul & deskripsi)
- [ ] Skills (nama skill sesuai keahlian)
- [ ] Contact information (nomor, email, social media)
- [ ] Brand name/logo (di navbar)
- [ ] Page title (di head)

### Images (img/ folder):

- [ ] Profile photo untuk hero section
- [ ] About photo
- [ ] 4 portfolio sample images

### Colors (CSS - style.css):

- [ ] Primary color (#ff6b35)
- [ ] Secondary color

### Social Media:

- [ ] Instagram link
- [ ] Facebook link
- [ ] YouTube link
- [ ] Email address

---

## 🎨 TIPS EDITING

### Untuk Edit HTML:

1. Buka file `index.html` dengan text editor (VS Code, Notepad++, dll)
2. Cari text yang ingin diubah
3. Edit teks
4. Save file (Ctrl+S)
5. Refresh browser untuk lihat perubahan

### Untuk Edit CSS:

1. Buka file `css/style.css`
2. Cari CSS variable atau class yang ingin diubah
3. Edit nilai
4. Save file
5. Hard refresh browser (Ctrl+F5)

### Untuk Edit Gambar:

1. Siapkan gambar Anda (format JPG atau PNG)
2. Taruh di folder `img/`
3. Update src di HTML
4. Refresh browser

---

## 🔧 PERBAIKAN TERBARU (v1.1)

### ✅ Hamburger Menu

- **Fitur:** Garis beranimasi saat diklik (hanya di mobile)
- **Lokasi:** Top-right navbar
- **Cara kerja:** Klik menu → animasi 3 garis jadi X → menu dropdown muncul dari atas
- **File CSS:** Baris 145-200

### ✅ Menu Dropdown Mobile

- **Fitur:** Menu muncul dari atas ke bawah dengan smooth animation
- **Duration:** 0.4 detik
- **Background:** Semi-transparent dark dengan blur effect
- **File CSS:** Baris 170-200

### ✅ Responsive Smartphone

- **Font lebih kecil:** 12-14px
- **Padding lebih compact:** 1rem atau lebih kecil
- **Buttons full width:** Optimal untuk tap di mobile
- **File CSS:** Baris 900-1010

### ✅ Scroll to Top Button

- **Lokasi:** Kanan bawah (fixed position)
- **Warna:** Orange (primary color)
- **Muncul saat:** Scroll lebih dari 300px
- **Animasi:** Hover effect dengan shadow
- **File CSS:** Baris 790-825

---

## 📞 CONTOH CUSTOMISASI LENGKAP

### Contoh 1: Mengganti Warna

**Sebelum:**

```css
--primary-color: #ff6b35; /* Orange */
```

**Sesudah:**

```css
--primary-color: #8b5cf6; /* Purple */
```

**Hasil:** Semua tombol, accent, dan hover effects berubah menjadi purple

---

### Contoh 2: Mengganti Hero Title

**Sebelum:**

```html
<h1 class="hero-title">
  Graphic Designer <span class="text-orange">&</span><br />
  Web Developer
</h1>
```

**Sesudah:**

```html
<h1 class="hero-title">
  WebAssist Specialist <span class="text-orange">&</span><br />
  Tech Consultant
</h1>
```

---

### Contoh 3: Menambah Portfolio Item Baru

**Pastikan kategorinya benar:**

```html
<!-- Untuk Graphic Design -->
<div class="portfolio-item" data-category="design">
  <img src="img/branding-project.jpg" alt="Project Name" />
  <div class="overlay">
    <h3>Corporate Branding Package</h3>
  </div>
</div>

<!-- Untuk Web Development -->
<div class="portfolio-item" data-category="web">
  <img src="img/ecommerce-site.jpg" alt="Project Name" />
  <div class="overlay">
    <h3>E-Commerce Store Implementation</h3>
  </div>
</div>
```

---

## 🎓 PEMBELAJARAN LEBIH LANJUT

### HTML Basics:

- Tag images: `<img src="path" alt="description">`
- Links: `<a href="url">text</a>`
- Paragraphs: `<p>text</p>`

### CSS Basics:

- Colors: hex (#ff6b35) atau rgb(255,107,53)
- Font size: px (16px) atau rem (1rem = 16px)
- Spacing: padding, margin (1rem = 16px)

### VS Code Tips:

- Find & Replace: Ctrl+H
- Multi-cursor: Ctrl+D
- Comment: Ctrl+/
- Format code: Shift+Alt+F

---

## 🆘 TROUBLESHOOTING

### Gambar tidak tampil?

✅ Pastikan file ada di folder `img/`  
✅ Pastikan path benar di HTML  
✅ Format file: JPG, PNG, atau GIF

### Warna tidak berubah?

✅ Hard refresh browser (Ctrl+F5)  
✅ Clear cache  
✅ Pastikan syntax CSS benar (#XXXXXX)

### Menu tidak dropdown?

✅ Check console (F12) untuk error  
✅ Pastikan JavaScript loaded  
✅ Pastikan hamburger toggle ada di HTML

### Text tidak berubah?

✅ Pastikan edit di file `index.html` yang benar  
✅ Save file setelah edit  
✅ Refresh browser

---

## 📧 SUPPORT

Jika ada yang tidak jelas, silakan tanyakan atau cek file dokumentasi lain:

- DEVELOPER_NOTES.md - Technical details
- PORTFOLIO_DOCUMENTATION.md - Full documentation
- README.md - Quick reference

---

**Version:** 1.1 - Updated  
**Status:** ✅ Ready for Customization  
**Last Updated:** 9 Februari 2026

Happy Customizing! 🎨✨
