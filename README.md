Here is a **professional, detailed, and elegant `README.md`** for your GitHub repository — tailored for your **royal-themed blog app**, with full feature documentation, setup instructions, and visual appeal.

---

### ✅ `README.md`

```markdown
# 📜 Royal Manuscript  
*A regal, black-and-white blog application with elegant typography, real-time search, categories, and Markdown-powered content.*

![Royal Manuscript Banner](https://via.placeholder.com/820x300/0a0a0a/f0f0f0?text=Royal+Manuscript+-+A+Regal+Blog+Platform)  
*(Replace with actual banner/screenshot when deployed)*

---

## 🌟 Overview

**Royal Manuscript** is a sophisticated, self-hosted blog platform designed to mimic the aesthetic of 18th-century royal decrees and handwritten manuscripts — all in a refined black-and-white palette.

Built with modern web standards but inspired by classical typography (Cormorant Garamond, Cinzel), this app delivers a **luxurious reading and writing experience**, whether you're publishing poetry, essays, journals, or scholarly reflections.

✅ Fully responsive  
✅ Dark & light mode  
✅ Image uploads + Markdown  
✅ Real-time search & category filtering  
✅ Secure auth (email/password)  
✅ Zero external dependencies (except Font Awesome & Google Fonts)

---

## 🚀 Features

| Category | Feature |
|---------|---------|
| 🎨 **UI/UX** | - Black-and-white "royal manuscript" theme<br>- Elegant serif typography (Cinzel, Cormorant Garamond)<br>- Smooth animations & hover effects<br>- Mobile-first responsive design |
| 🔐 **Authentication** | - Secure login/register<br>- Session-based auth (PHP `$_SESSION`)<br>- Password hashing (`password_hash`) |
| ✍️ **Content** | - Rich Markdown editor (SimpleMDE)<br>- Image uploads (JPG/PNG/WebP)<br>- Post creation, editing, deletion |
| 🔍 **Discovery** | - Real-time search (as you type)<br>- Category filtering (with API-backed filtering)<br>- 25%/75% image/content layout |
| 📱 **Mobile** | - Fully responsive: image scaling (`object-fit: contain`)<br>- No overflow, full-image visibility on small screens<br>- Touch-friendly controls |
| 🛡️ **Security** | - Prepared statements (PDO) to prevent SQL injection<br>- Input validation & sanitization<br>- CSRF-safe (session-bound actions) |
| 🖥️ **Hosting** | - Works on XAMPP, WAMP, InfinityFree, and standard LAMP stacks<br>- No frameworks — pure PHP/JS/HTML/CSS |

---

## 📂 Project Structure

```
blog-app/
├── backend/
│   ├── api/
│   │   ├── auth/         # login, register, check, logout
│   │   ├── posts/        # CRUD: create, list, edit, delete, get
│   │   └── categories/   # list
│   ├── config/
│   │   └── db.php       # DB connection (MySQL)
│   └── includes/
│       └── auth.php      # auth helpers (requireLogin, isOwner)
├── frontend/
│   ├── css/
│   │   └── style.css     # Royal black-and-white theme ✨
│   ├── js/
│   │   ├── main.js       # Core utilities (escapeHtml, checkAuth, logout)
│   │   └── theme.js      # Dark/light mode toggle
│   ├── lib/
│   │   ├── marked.min.js # Markdown parser
│   │   ├── simplemde.min.js
│   │   └── simplemde.min.css
│   └── pages/
│       ├── index.html    # Homepage (search + category + posts)
│       ├── login.html
│       ├── register.html
│       ├── create.html
│       ├── edit.html
│       ├── view.html     # Single post (responsive images)
│       └── profile.html
├── uploads/              # User-uploaded images (auto-created)
└── sql/
    └── blog_schema.sql   # Database schema (users, posts, categories)
```

---

## ⚙️ Installation

### Prerequisites
- PHP 7.4+ (with `pdo_mysql`, `session`)
- MySQL/MariaDB
- Web server (Apache/Nginx)

### 1. Clone & Setup
```bash
git clone https://github.com/your-username/royal-manuscript.git
cd royal-manuscript
```

### 2. Create Database
Run this SQL (or import `sql/blog_schema.sql`):
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

-- Sample categories (optional)
INSERT INTO category (name) VALUES 
  ('Literature'), ('Philosophy'), ('History'), 
  ('Science'), ('Travel'), ('Personal');
```

### 3. Configure Database
Edit `backend/config/db.php`:
```php
$host = 'localhost';
$dbname = 'blog_db';
$db_user = 'your_db_user';
$db_pass = 'your_db_password'; // ← never leave empty on shared hosts!
```

### 4. Set Permissions
Ensure `uploads/` is writable:
```bash
chmod -R 755 uploads/
# On shared hosting (e.g., InfinityFree), this is usually automatic
```

### 5. Deploy
- Copy entire project to web root (e.g., `htdocs/blog-app/`)
- Visit: `http://localhost/blog-app/frontend/pages/login.html`

> 💡 **For InfinityFree**:  
> - Use the provided DB credentials from the control panel  
> - Ensure `db_pass` is **not empty**  
> - Test `/backend/api/auth/check.php` first to confirm DB connection

---

## 🧪 Demo

| Page | Screenshot |
|------|------------|
| **Homepage** | ![Homepage: search, categories, responsive posts](https://via.placeholder.com/400x250/eaeaea/333?text=Homepage+-+25%25+Image+%2B+75%25+Text) |
| **Create Post** | ![Editor with Markdown + royal UI](https://via.placeholder.com/400x250/f5f5f5/000?text=Create+Post+--+SimpleMDE+%2B+Categories) |
| **Mobile View** | ![Mobile: full-width image, no overflow](https://via.placeholder.com/200x350/0f0f0f/f0f0f0?text=Mobile+--+Responsive+Images) |

*(Add real screenshots to `/docs/` and update links)*

---

## 🔐 Security Notes

- ✅ All DB queries use **prepared statements**
- ✅ User passwords are hashed with `password_hash` (bcrypt)
- ✅ Session-based auth (no JWT tokens → simpler & secure for this scale)
- ✅ Image uploads validated (type, size, extension)
- ✅ HTML output escaped (`escapeHtml()` utility)
- ❌ No rate limiting (for production, add login attempt limits)

---

## 🎨 Customization

### Change Theme Colors
Edit CSS variables in `style.css`:
```css
:root {
  --primary: #1a1a1a;   /* Deep graphite */
  --accent: #c0c0c0;    /* Silver */
  --bg: #fdfdfd;        /* Parchment */
}
```

### Add New Fonts
Replace Google Fonts import in HTML:
```html
<link href="https://fonts.googleapis.com/css2?family=Cinzel&family=Cormorant+Garamond&display=swap" rel="stylesheet">
```

### Enable Dark Mode by Default
In `theme.js`:
```js
// Change this line:
const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

// To:
const prefersDark = true; // Always dark
```

---

## 📜 License

MIT License — free to use, modify, and distribute.

> *"Knowledge should be free, elegant, and timeless."*

---

## 🙏 Acknowledgements

- [**SimpleMDE**](https://github.com/sparksuite/simplemde-markdown-editor) — elegant Markdown editor
- [**marked.js**](https://github.com/markedjs/marked) — fast Markdown parser
- Google Fonts — *Cinzel*, *Cormorant Garamond*, *Libre Baskerville*
- Font Awesome — icons

---

## 📬 Feedback & Contributions

Issues, PRs, and royal decrees welcome!  
→ [Open an Issue](https://github.com/your-username/royal-manuscript/issues)  
→ Fork & contribute 🏰

---

> ✒️ *Crafted with care for writers who believe words deserve dignity.*  
> — *Your Name, Steward of the Royal Manuscript*
```

---

### ✅ Next Steps for You

1. **Replace placeholder images** with real screenshots (use `/docs/` folder)
2. **Update `your-username`** in URLs
3. **Add live demo link** (e.g., `https://dewmi.infinityfree.me`)
4. **Include `blog_schema.sql`** in `/sql/` directory

Would you like me to generate:
- A matching **banner image** (royal parchment style)?
- A **`CONTRIBUTING.md`** or **`SECURITY.md`**?
- A **1-click deploy button** for InfinityFree/Heroku?

Let me know — I’ll help make your repo shine like a crown jewel. 👑
