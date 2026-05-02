# 🌐 Nexus Core // Visual Command

Nexus Core is a custom-built, full-stack database application designed to act as a highly secure visual command center. It moves beyond standard CRUD operations by natively handling, storing, and rendering heavy 3D files directly within the browser grid.

# 🌐 Nexus Core // Visual Command Terminal

Nexus Core is a custom-engineered, full-stack command center and secure database. It is designed to act as a central hub for managing complex project data, game lore, and high-fidelity 3D assets. Unlike standard web applications, Nexus Core utilizes a custom backend architecture to handle and render heavy `.glb` files natively within a high-tech "Command Center" interface.

## 📡 Visual Recon (Dashboard Views)

<p align="center">
  <img src="assets/Screenshot%202026-05-02%20124902.png" width="90%" alt="Nexus Core Main Dashboard" />
  <br><em>View 01 // Master Command HUD</em>
</p>

<p align="center">
  <img src="assets/Screenshot%202026-05-02%20124915.png" width="90%" alt="Asset Injection Panel" />
  <br><em>View 02 // Asset Injection & Database Grid</em>
</p>

<p align="center">
  <img src="assets/Screenshot%202026-05-02%20124940.png" width="90%" alt="3D Render Core" />
  <br><em>View 03 // Real-time 3D Hologram Rendering</em>
</p>

## ⚡ Key Intelligence Features
*   **3D Hologram Grid:** Integrated Google `<model-viewer>` for real-time, interactive rendering of 3D assets.
*   **The Lore Vault:** A specialized rich-text engine powered by `Quill.js`, allowing for detailed documentation and formatted data storage.
*   **Heavy Payload Handling:** Custom Laravel routing and validation logic configured to bypass default server limits for 40MB+ file uploads.
*   **Dynamic Intelligence HUD:** A vanilla JavaScript frontend that calculates and displays real-time database statistics (Total Projects, Operatives, Status).
*   **Secure API Architecture:** Built on a RESTful Laravel framework with strict database migrations and relational data mapping.

## 🛠️ Technical Stack
*   **Backend:** PHP 8.x // Laravel 11
*   **Database:** MySQL (Relational Schema)
*   **Frontend:** JavaScript (ES6+), HTML5, CSS3
*   **Environment:** XAMPP, Git version control

## 🔧 Installation & Deployment
1. Clone the repository: `git clone https://github.com/nandhasriram/nexus-core.git`
2. Install dependencies: `composer install` & `npm install`
3. Configure environment: Rename `.env.example` to `.env` and set your database credentials.
4. Run migrations: `php artisan migrate`
5. Launch the terminal: `php artisan serve`

---
*Developed by Nandha Sriram — Engineering high-performance backend systems.*

## 🚀 Key Features
*   **3D Hologram Engine:** Utilizes Google's `<model-viewer>` to render complex `.glb` 3D assets natively on the frontend.
*   **Advanced File Routing:** Custom Laravel backend logic built to bypass standard upload constraints and securely preserve complex 3D file extensions.
*   **The Lore Engine:** Integrated with `Quill.js` to allow for deep, rich-text formatting and data storage within the MySQL vault.
*   **Dynamic Intelligence HUD:** Real-time JavaScript counters that track database statistics and live operative counts without server refreshes.
*   **Secure API Architecture:** Built on Laravel with strict validation rules and RESTful routing.

## 🛠️ Tech Stack
*   **Backend:** PHP, Laravel 11
*   **Database:** MySQL
*   **Frontend:** HTML5, CSS3, Vanilla JavaScript
*   **Libraries:** Quill.js (Rich Text), Model-Viewer (3D Rendering)
