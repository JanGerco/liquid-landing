# Liquid Landing — a one-page WordPress theme

A dark, single-page landing theme for a studio or agency: liquid gradient shapes that bleed off the page edges, a bold display face, a pinned "01 → 02 → 03" scroll stage, a two-second brand intro, a full-screen phone menu, and a working bilingual contact form. No page builder, no plugins, no build step — one PHP theme, one stylesheet, one script.

Everything on the page is placeholder copy. Replace the strings, the mark, and the shapes, and it's yours.

## Sections

Hero · About · Why quality matters (three stat rings) · Services (two groups) · Vision / Mission / Support (pinned stage) · Work (grid, optional) · Contact (form + details) · Footer.

## What's in it

- **Design tokens.** Every colour, size, radius, duration, shadow and z-index comes from `assets/css/tokens.css`; the brand layer at the top of `assets/css/theme.css` is the only place raw values appear. Change six colours and two fonts there and the whole page follows.
- **Liquid shapes.** Nine gradient shapes in `assets/img/blobs/`, positioned on the seams between sections and clipped only by the page edge — never mid-shape, never under text. They drift slowly; motion stops under `prefers-reduced-motion`.
- **Pinned stage.** The vision / mission / support section sticks under the header while the page scrolls past it and switches the active numeral. Native scrolling only; falls back to a stacked list without JS or on short screens.
- **Brand intro.** Once per browser session: a dot blooms, splits, stretches into two bars, a gradient ribbon is drawn between them, and the finished mark flies into the header. Any input skips it; reduced-motion users never see it; the page loads underneath in parallel.
- **Three tiers.** Phone (≤ 640 px) single column with a full-screen overlay menu whose links arrive one by one; tablet (640–1023 px) two-column sections; desktop (≥ 1024 px) the full composition.
- **Bilingual.** RO / EN strings in `inc/i18n.php`; `?lang=en` sets a cookie, `<html lang>` and `hreflang` follow, both versions are indexable.
- **Contact form.** `wp_mail` to the site's admin email, with nonce, honeypot, one-message-per-minute rate limit, inline validation, JSON replies with JS and a plain redirect without.
- **Accessibility.** Semantic landmarks, one `h1`, visible focus rings, 44 px targets, five button states, keyboard-operable menu (Esc closes, focus returns), logical properties, `forced-colors` support.
- **Compatibility.** WordPress 6.3+, PHP 7.4+ (8.x recommended). Every non-front URL 301s to `/`.

## Make it yours

| Change | Where |
|---|---|
| Name, copy, labels (both languages) | `inc/i18n.php` |
| Phone and email | `front-page.php` (contact section) and `footer.php`; the form delivers to Settings → General → Administration Email |
| Colours, fonts, display sizes | brand layer at the top of `assets/css/theme.css` |
| Mark (header + favicon) | `assets/img/mark.svg`, `mark-mono.svg`; the intro draws the same geometry — adjust the paths in `header.php` if you change the mark |
| Shapes | `assets/img/blobs/blob-01…09.webp` (transparent WebP, any size); positions per tier are in `theme.css` |
| Portfolio | `inc/portfolio.php` — the section appears once the list has items; screenshots go in `assets/img/portfolio/<slug>.jpg` (1317 × 875) |
| Intro | delete the `#intro` block in `header.php` to remove it; timings in the "Intro" block of `theme.css` |

## Install

1. `python scripts/build-zip.py` → `deploy/liquid-landing.zip`
2. WordPress → Appearance → Themes → Add New → Upload Theme → Activate.
3. Leave Settings → Reading on "Your latest posts" — the theme ignores pages and posts; the whole site is `front-page.php`.

Bump `Version:` in `style.css` and `LL_VERSION` in `functions.php` for each release so browsers fetch fresh CSS/JS.

## Licence

MIT — see [LICENSE](LICENSE). Fonts Outfit and Poppins load from Google Fonts under the SIL Open Font License.
