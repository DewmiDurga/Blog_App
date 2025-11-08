### ✅ `README.md`

```markdown
# 📜 **Royal Manuscript**  
*A regal, black-and-white blog platform inspired by 18th-century manuscripts — built with pure PHP, MySQL, and vanilla frontend.*

[![Live Demo](https://img.shields.io/badge/demo-live-2ea44f?style=flat-square&logo=firefox)](https://dewmi.infinityfree.me)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?logo=php)](https://www.php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-4479A1?logo=mysql)](https://www.mysql.com)
[![License](https://img.shields.io/badge/license-MIT-blue)](LICENSE)

> *“Words deserve dignity. Let them be written — and read — like royal decrees.”*

---

## 🌟 Features

| Category | Capability |
|---------|------------|
| ✍️ **Content** | Markdown-powered posts (via **SimpleMDE**), featured image uploads (JPG/PNG/WebP) |
| 🔍 **Discovery** | Real-time search (as-you-type), category filtering, responsive layouts |
| 🎨 **Design** | Black-and-white “royal manuscript” UI, dark/light mode, elegant serif typography (**Cinzel**, **Cormorant Garamond**) |
| 🔒 **Security** | `password_hash()` auth, PDO prepared statements, XSS sanitization, CSRF-safe sessions |
| 📱 **Mobile** | Fully responsive — images scale to fit screen (no overflow, no cropping) |
| 🚀 **Deployment** | Works on **XAMPP (local)** and **InfinityFree (free hosting)** |

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|------------|
| **Frontend** | HTML5, CSS3 (Flexbox/Grid), Vanilla JS |
| **Markdown** | [SimpleMDE](https://simplemde.com) (editor), [Marked.js](https://marked.js.org) (parser) |
| **Backend** | PHP 7.4+ (procedural, no frameworks) |
| **Database** | MySQL 5.7+ |
| **Fonts** | Google Fonts: `Cinzel`, `Cormorant Garamond`, `Libre Baskerville` |
| **Icons** | Font Awesome 6.4 |

✅ **Zero external dependencies** — no Node.js, no Composer, no npm.

---

## 📂 Project Structure

```
royal-manuscript/
├── backend/
│   ├── config/db.php          # DB connection + session init
│   ├── includes/auth.php      # auth helpers (`requireLogin`, `isOwner`)
│   └── api/
│       ├── auth/              # login, register, logout, check
│       ├── posts/             # CRUD: create, edit, list, delete, get
│       └── categories/        # list (for filters)
├── frontend/
│   ├── css/style.css          # Royal black-and-white theme
│   ├── js/
│   │   ├── main.js            # Core: `escapeHtml`, `checkAuth`, `logout`
│   │   └── theme.js           # Dark/light toggle
│   ├── lib/                   # Vendored: SimpleMDE, Marked.js
│   └── pages/                 # All HTML pages (flat structure)
├── uploads/                   # Auto-created on first image upload
└── sql/
    └── schema.sql             # Full DB schema (users, posts, categories)
```

💡 **Architecture Principle**:  
Frontend ↔ **REST-like PHP API** — no embedded PHP in `.html` files.

---

## 🚀 Local Setup (XAMPP)

### Prerequisites
- [XAMPP](https://www.apachefriends.org) (Apache + MySQL)
- Modern browser (Chrome/Firefox/Safari)

### Steps
1. **Clone** into `htdocs/`:
   ```bash
   git clone https://github.com/your-username/royal-manuscript.git
   cd royal-manuscript
   ```

2. **Create database** (`blog_db`) in phpMyAdmin:
   ```sql
   CREATE DATABASE blog_db;
   USE blog_db;

   -- Users
   CREATE TABLE user (
     id INT AUTO_INCREMENT PRIMARY KEY,
     username VARCHAR(50) NOT NULL UNIQUE,
     email VARCHAR(100) NOT NULL UNIQUE,
     password VARCHAR(255) NOT NULL
   );

   -- Categories
   CREATE TABLE category (
     id INT AUTO_INCREMENT PRIMARY KEY,
     name VARCHAR(100) NOT NULL UNIQUE
   );

   -- Posts
   CREATE TABLE blogPost (
     id INT AUTO_INCREMENT PRIMARY KEY,
     user_id INT NOT NULL,
     title VARCHAR(255) NOT NULL,
     content TEXT NOT NULL,
     image VARCHAR(255) NULL,
     category_id INT NULL,
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
     FOREIGN KEY (category_id) REFERENCES category(id) ON DELETE SET NULL
   );
   ```

3. **Start Apache & MySQL** in XAMPP Control Panel

4. **Visit**: [`http://localhost/royal-manuscript/frontend/pages/login.html`](http://localhost/royal-manuscript/frontend/pages/login.html)

---

## ☁️ Deployment (InfinityFree)

1. **Adjust paths**:
   - Replace `/royal-manuscript/` → `/` in all JS `fetch()` URLs
   - Update `backend/config/db.php` with InfinityFree credentials

2. **Upload** via File Manager or FTP:
   - ⚠️ Skip `uploads/` — let the app create it
   - Ensure `uploads/` is writable (755)

3. **Import SQL** via phpMyAdmin

4. **Go live**: `https://dewmi.infinityfree.me`

> 🔐 **Security Tip**: Never commit `db.php` with real passwords. Use `.gitignore`.

---

## 🛡️ Security Hardening

| Threat | Mitigation |
|-------|------------|
| **SQL Injection** | All queries use PDO prepared statements |
| **XSS** | Output escaped via `escapeHtml()` (JS) + allowed-tags sanitization (PHP) |
| **Password Leaks** | `password_hash()` (bcrypt) + no plaintext storage |
| **Session Hijacking** | `HttpOnly` cookies (via PHP session config) |
| **File Uploads** | Type/size validation, unique filenames, `uploads/` outside web root* |

> \* *On InfinityFree, `uploads/` is in web root — but filenames are unpredictable.*

---

## 🎨 UI Design Principles

- **Color Palette**:  
  `--primary: #1a1a1a` (graphite), `--accent: #c0c0c0` (silver), `--bg: #fdfdfd` (parchment)  
- **Typography**:  
  - Headings: `Cinzel` (regal serif)  
  - Body: `Libre Baskerville` (readable manuscript style)  
  - Code: `JetBrains Mono`  
- **Layout**:  
  - Homepage: 25% image / 75% content grid  
  - Mobile: Full-width images with `object-fit: contain` (no cropping)  

![UI Preview](docs/ui-preview.jpg)  
*(Add real screenshots to `/docs/`)*

---

## 🧪 Testing Checklist

| Test | Expected |
|-----|----------|
| Register → Login | Redirect to homepage, monogram greeting |
| Create post (with image) | Appears in list, image visible on mobile |
| Search "travel" | Filters posts in real-time |
| Click "Philosophy" | Shows only philosophy posts |
| Edit post (own) | Success |
| Edit post (others') | ❌ 403 Forbidden |
| Toggle dark mode | Persists across pages |

---

## 📜 License

MIT — free to use, modify, and distribute.

> *"Knowledge should be free, elegant, and timeless."*

---

## 🙏 Credits

- [SimpleMDE](https://github.com/sparksuite/simplemde-markdown-editor) — elegant Markdown editor  
- [Marked.js](https://github.com/markedjs/marked) — secure Markdown parsing  
- Google Fonts — `Cinzel`, `Cormorant Garamond`, `Libre Baskerville`  
- Font Awesome — icons  

---

> ✒️ **Crafted with care for writers who believe words deserve dignity.**  
> — *Your Name, Steward of the Royal Manuscript*

---

✅ **Ready to deploy, extend, or inspire.**  
Just `git clone`, set up your database, and begin your reign.

---

> 📬 **Feedback?** Open an issue — all royal decrees welcome. 👑
```

---

### ✅ To Use:
1. Save as `README.md` in your repo root
2. Replace `your-username` and `dewmi.infinityfree.me` with your details
3. Add real screenshots to `/docs/` and update image links

Would you like me to generate:
- A matching `CONTRIBUTING.md`
- A `SECURITY.md` with vulnerability reporting guidelines
- GitHub Actions workflow for auto-deploy to InfinityFree?


