# Frontend UI and Design System

LingoPulse features a modern, high-fidelity user interface built with Vanilla CSS and Laravel Blade. It prioritizes a premium "Glassmorphism" aesthetic.

## 1. Design Principles

- **Glassmorphism**: Extensive use of high-quality blur, semi-transparent backgrounds, and thin borders to create a layered, depth-based UI.
- **Dynamic Lighting**: Backgrounds use large, slow-moving radial gradients (`.light` class) to give the application an "alive" feel.
- **Micro-Animations**: Buttons and cards utilize CSS transitions on `transform` and `box-shadow` to provide tactile feedback to user interactions.

## 2. Core Color Palette (CSS Variables)

The design system is defined through CSS variables in `:root`:

| Variable | Value (Primary) | Use Case |
| :--- | :--- | :--- |
| `--bg` | `#000c1d` | Main page background. |
| `--card` | `rgba(255,255,255,0.085)` | Glass container backgrounds. |
| `--brand1` | `#00c6ff` | Gradient start / Primary accent. |
| `--brand2` | `#0086ff` | Gradient end / Action accent. |
| `--radius` | `26px` | Standard corner rounding. |

## 3. Layout Structure

- **Navigation**: Managed via `topbar` and `topbar-inner` which are fixed to the viewport top with `backdrop-filter: blur(16px)`.
- **Content Containers**: The `shell` class keeps the content centered and responsive across screen sizes.
- **Grid System**: Use of `display: grid` (e.g., in `main` layout) for side-by-side reading passages and question scroll areas.

## 4. Blade Templates

LingoPulse uses a non-component-based Blade architecture to keep styles scoped and performant.

- **`index.blade.php`**: The landing page, serving as the gateway for Students, Teachers, and Admins.
- **`dynamicReading.blade.php` & `dynamicListening.blade.php`**: Purpose-built templates for AI-generated content.
- **`results.blade.php`**: A data-heavy view that visualizes scores and renders AI-generated analysis.

## 5. Responsiveness

Media queries are used to shift from a multi-column "desktop" layout to a single-column "mobile" stack at `980px`. The scroll logic (`qscroll`) adjusts so that mobile users can navigate long lists of questions easily without losing the top navigation.

## 6. Security (UI Level)

To protect the integrity of the English proficiency exam, the frontend includes JavaScript "hardening":
- **Disabled Actions**: Copying, Cutting, Pasting, and Context Menus (Right-Click) are disabled in the exam views.
- **Browser Protection**: Detection of `F12` (DevTools) and `Ctrl/Cmd` shortcuts to prevent unauthorized access to test data or prompt injection.
