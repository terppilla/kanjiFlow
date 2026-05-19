# Troubleshooting

## 500 on `/css/*.css`, `/img/*.svg` (site unstyled, broken images)

**Symptom:** Browser shows `500` for `app.css`, `landing.css`, SVG icons. Main HTML page may load (200). Errors differ between refreshes.

**Cause:** Document root is the project root (`public_html`), not `public/`. Apache sends static URLs to `index.php` (Laravel) or PHP tries to execute `.css`/`.svg`.

### Fix on server (SSH)

```bash
cd ~/public_html   # your project root

git pull origin main

# Symlinks: /img, /css, /js at root → public/img, etc.
bash scripts/link-public-assets.sh

# Web server must read files (600 → 500)
find public -type d -exec chmod 755 {} \;
find public -type f -exec chmod 644 {} \;

php artisan optimize:clear
```

### If `link-public-assets.sh` fails

You may have old folders from a bad deploy (`css/`, `img/` in project root, not symlinks):

```bash
ls -la css img js
# If they are real directories with wrong content:
mv css css.bak.old
mv img img.bak.old
mv js js.bak.old
bash scripts/link-public-assets.sh
```

### Best long-term fix (hosting panel)

Set **document root** to `public_html/public` (only one `.htaccess`, standard Laravel). Then symlinks are optional.

### Verify

```bash
curl -I https://your-domain.ru/css/app.css
curl -I https://your-domain.ru/img/KANJIFLOW.svg
```

Expect `HTTP/2 200` and `Content-Type: text/css` / `image/svg+xml`. If you still see `500`, check `storage/logs/laravel.log` at the same timestamp — if a new line appears, requests still reach Laravel.

### `.env`

```env
APP_URL=https://your-domain.ru
```

## Lighthouse: huge payload / slow landing

**Symptom:** `hero-dragon.svg` ~2.6 MB in network tab; Google Fonts ~600 KiB; main-thread work several seconds.

**Cause:** `hero-dragon.svg` embedded a 2560×2560 PNG. CJK Google Fonts on a Russian landing page.

**Fix in repo:** Use `public/img/hero-dragon.jpg` (~140 KiB). Landing uses `fonts-landing.blade.php` (Noto Sans/Serif + tiny `Noto Serif SC` subset for 學習). After deploy, remove old `hero-dragon.svg` on the server if it remains.

```bash
rm -f public/img/hero-dragon.svg public/img/hero-dragon.png
```
