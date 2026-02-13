# ✅ QUICK CUSTOMIZATION CHECKLIST

## Ar Creative Portfolio - Bagian Yang Perlu Diganti

---

## 🎯 PRIORITAS TINGGI (WAJIB GANTI)

### 1. PROFILE PHOTO (Hero Section) ⭐⭐⭐

```
📍 Lokasi: Bagian atas website (di kanan teks)
📄 File: index.html - Baris 84-93
🖼️ Ukuran: 400x400px recommended
📝 Ganti: <img src="img/profile-photo.jpg">
```

**Instruksi:**

1. Siapkan foto Anda (JPG atau PNG)
2. Taruh di folder: `img/profile-photo.jpg`
3. Edit HTML baris 84-93
4. Refresh browser

---

### 2. HERO TITLE & SUBTITLE ⭐⭐⭐

```
📍 Lokasi: Teks besar "Graphic Designer & Web Developer"
📄 File: index.html - Baris 62-70
📝 Contoh:
   SUBTITLE: "I AM [NAMA ANDA]"
   TITLE: "[PROFESI 1] & [PROFESI 2]"
   DESCRIPTION: "[Deskripsi singkat layanan Anda]"
```

**Instruksi:**

```html
SEBELUM:
<p class="hero-subtitle">I AM AR CREATIVE</p>
<h1 class="hero-title">
  Graphic Designer <span class="text-orange">&</span><br />
  Web Developer
</h1>

SESUDAH:
<p class="hero-subtitle">I AM NAMAMU</p>
<h1 class="hero-title">
  UI Designer <span class="text-orange">&</span><br />
  Brand Specialist
</h1>
```

---

### 3. ABOUT ME TEXT ⭐⭐⭐

```
📍 Lokasi: Section "About Me" (scroll turun)
📄 File: index.html - Baris 110-125
📝 Isi dengan: Bio/biografi Anda, pengalaman, keahlian
```

**Instruksi:**
Ganti semua text di dalam `<div class="about-text">`

---

### 4. PORTFOLIO IMAGES (4 buah) ⭐⭐

```
📍 Lokasi: Section "Portfolio" (scroll turun lebih jauh)
📄 File: index.html - Baris 285-325
🖼️ Ukuran: 300x300px recommended
📝 Kategori: "design" atau "web"
```

**Instruksi:**

```html
PORTFOLIO ITEM 1 (Design)
<div class="portfolio-item" data-category="design">
  <img src="img/portfolio-design-1.jpg" alt="Project Name" />
  <div class="overlay">
    <h3>Project Title</h3>
  </div>
</div>

PORTFOLIO ITEM 2 (Web)
<div class="portfolio-item" data-category="web">
  <img src="img/portfolio-web-1.jpg" alt="Project Name" />
  <div class="overlay">
    <h3>Project Title</h3>
  </div>
</div>

(Ulangi untuk item 3 dan 4)
```

---

### 5. SERVICES (6 Cards) ⭐⭐

```
📍 Lokasi: Section "Services"
📄 File: index.html - Baris 330-395
📝 Update: Judul, deskripsi, harga setiap service
```

**Template untuk setiap service:**

```html
<div class="service-card">
  <div class="service-icon">
    <i class="fas fa-[ICON-NAME]"></i>
  </div>
  <h3>[NAMA SERVICE]</h3>
  <p>[DESKRIPSI SINGKAT]</p>
  <div class="service-price">[HARGA/RANGE HARGA]</div>
</div>
```

---

## 🎨 PRIORITAS SEDANG (SANGAT PENTING)

### 6. CONTACT INFORMATION

```
📍 Lokasi: Section "Contact" (footer area)
📄 File: index.html - Baris 500-540
📝 Ganti: WhatsApp, Email, Nama, Link sosial media
```

**Instruksi:**

```html
SEBELUM:
<p><strong>WhatsApp Personal:</strong> +62 812-4861-6454</p>
<p><strong>Email:</strong> suportarcreative@gmail.com</p>

SESUDAH:
<p><strong>WhatsApp Personal:</strong> +62 [NOMOR ANDA]</p>
<p><strong>Email:</strong> [EMAIL ANDA]</p>
```

---

### 7. SOCIAL MEDIA LINKS

```
📍 Lokasi: Footer (bagian bawah)
📄 File: index.html - Baris 580-590
📝 Ganti: Instagram, Facebook, YouTube, LinkedIn links
```

**Instruksi:**

```html
SEBELUM:
<a href="https://instagram.com/arcreative_26">
  SESUDAH:
  <a href="https://instagram.com/[USERNAME ANDA]"></a
></a>
```

---

### 8. BRAND NAME / LOGO

```
📍 Lokasi: Navbar (atas website)
📄 File: index.html - Baris 36
📝 Ganti: "Ar Creative" → "[NAMA BRAND ANDA]"
```

---

## 🎨 PRIORITAS RENDAH (OPSIONAL)

### 9. PRIMARY COLOR (Brand Color)

```
📍 Lokasi: Semua elemen orange di website
📄 File: css/style.css - Baris 13
📝 Ganti: #ff6b35 → [WARNA FAVORIT ANDA]
```

**Warna Suggestions:**

```css
Purple:  #8B5CF6
Blue:    #3B82F6
Green:   #10B981
Red:     #EF4444
Pink:    #EC4899
```

---

### 10. SECONDARY COLOR

```
📍 Lokasi: Accent color (dark blue)
📄 File: css/style.css - Baris 14
📝 Ganti: #004e89 → [WARNA SECONDARY]
```

---

### 11. PAGE TITLE

```
📍 Lokasi: Tab browser
📄 File: index.html - Baris 6
📝 Ganti: "Ar Creative - Portfolio | Graphic Designer & Web Developer"
    → "[NAMA] - Portfolio | [PROFESI]"
```

---

### 12. SKILLS DATA (Chart)

```
📍 Lokasi: Resume section (doughnut chart)
📄 File: index.html - Baris 409-420
📝 Ganti nama skill & persentase sesuai keahlian Anda
```

**Instruksi:**

```javascript
SEBELUM:
labels: [
  "Design Grafis (90%)",
  "CMS Web Dev (80%)",
  "Content Management (78%)",
  "IT Support (85%)",
],

SESUDAH:
labels: [
  "Skill 1 (XX%)",
  "Skill 2 (XX%)",
  "Skill 3 (XX%)",
  "Skill 4 (XX%)",
],
```

---

## 📋 EDITING CHECKLIST

Copy & paste checklist ini, mark saat sudah selesai:

```
PROFILE & IDENTITY
[ ] Hero profile photo
[ ] Hero title & subtitle
[ ] About me text & photo
[ ] Brand name (logo)

CONTENT
[ ] All 6 services updated
[ ] Services descriptions
[ ] Services pricing
[ ] Skills data (chart)

PORTFOLIO
[ ] 4 portfolio images
[ ] Portfolio titles
[ ] Category (design/web)

CONTACT & SOCIAL
[ ] WhatsApp number
[ ] Email address
[ ] Instagram link
[ ] Facebook link
[ ] YouTube link
[ ] LinkedIn (opsional)

APPEARANCE
[ ] Primary color (opsional)
[ ] Secondary color (opsional)
[ ] Brand name in navbar

FINAL CHECK
[ ] All images loaded ✓
[ ] No broken links ✓
[ ] Responsive on mobile ✓
[ ] All text updated ✓
[ ] Colors match brand ✓
```

---

## 🖼️ IMAGE LOCATIONS & SIZES

### Profile Photo (Hero)

```
Path: img/profile-photo.jpg
Size: 400x400px
Format: JPG, PNG
Location: Hero section (top right)
```

### About Photo

```
Path: img/about-photo.jpg
Size: 400x400px
Format: JPG, PNG
Location: About section (left side)
```

### Portfolio Images (4 buah)

```
Path: img/portfolio-1.jpg, portfolio-2.jpg, etc
Size: 300x300px (minimum)
Format: JPG, PNG
Location: Portfolio grid section
Category: design atau web
```

---

## 🚀 QUICK EDIT GUIDE

### Step 1: Open Text Editor

```
Windows: Right-click → "Open with" → "Choose another app"
macOS: Right-click → "Open With" → "TextEdit" or VS Code
Linux: Open with your favorite editor
```

### Step 2: Find & Replace

```
Shortcut: Ctrl+H (atau Cmd+H di Mac)
Find: Old text
Replace: New text
Replace All: Click button
```

### Step 3: Common Replacements

```
1. "Ar Creative" → "Your Name"
2. "suportarcreative@gmail.com" → "your@email.com"
3. "+62 812-4861-6454" → "Your WhatsApp"
4. "@arcreative_26" → "@your_instagram"
5. "Graphic Designer & Web Developer" → "Your profession"
```

### Step 4: Save & Test

```
Save: Ctrl+S
Refresh browser: F5 atau Ctrl+F5 (hard refresh)
Check: Does it look correct?
```

---

## ⚠️ COMMON MISTAKES

### ❌ Kesalahan Umum & Cara Mengatasi:

1. **Gambar tidak tampil**
   - ❌ Path salah: `img\profile.jpg` (backslash Windows)
   - ✅ Ganti: `img/profile.jpg` (forward slash)

2. **Link tidak berfungsi**
   - ❌ Lupa "http://": `instagram.com/username`
   - ✅ Ganti: `https://instagram.com/username`

3. **Warna tidak berubah**
   - ❌ Belum hard refresh
   - ✅ Coba: Ctrl+F5 (hard refresh)

4. **Text tidak berubah**
   - ❌ Edit file salah
   - ✅ Pastikan edit di `index.html`

5. **Dropdown menu error**
   - ❌ Hapus HTML yang seharusnya
   - ✅ Hanya ganti text, jangan hapus tag

---

## 📞 REFERENCE LINKS

### Icons (Font Awesome):

- Icon list: https://fontawesome.com/icons

### Colors:

- Color picker: https://colorpicker.com/
- Color palette: https://coolors.co/

### Social Media URLs:

```
Instagram: https://instagram.com/[username]
Facebook: https://facebook.com/[username]
YouTube: https://youtube.com/@[channel]
LinkedIn: https://linkedin.com/in/[username]
TikTok: https://tiktok.com/@[username]
```

---

## ✅ FINAL VERIFICATION

Sebelum launch, pastikan:

1. **Content**
   - [ ] Semua text sudah diganti
   - [ ] Tidak ada placeholder yang ketinggalan
   - [ ] Grammar dan spelling benar

2. **Images**
   - [ ] Semua gambar sudah di-upload
   - [ ] Ukuran optimal (tidak terlalu besar)
   - [ ] Format benar (JPG/PNG)

3. **Links**
   - [ ] Semua social media links aktif
   - [ ] Email & WhatsApp berfungsi
   - [ ] Portfolio filter bekerja

4. **Responsive**
   - [ ] Test di mobile (width 375px)
   - [ ] Test di tablet (width 768px)
   - [ ] Test di desktop (width 1920px)

5. **Browser**
   - [ ] Test di Chrome ✓
   - [ ] Test di Firefox ✓
   - [ ] Test di Safari ✓

---

**Status:** ✅ Ready for Customization  
**Last Updated:** 9 Februari 2026  
**Version:** 1.1 Updated

Sudah siap? Mari mulai kustomisasi! 🎨✨
