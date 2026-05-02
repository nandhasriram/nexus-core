<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus Core | Visual Terminal</title>

    <!-- Target Golf: The 3D Rendering Engine -->
    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.4.0/model-viewer.min.js"></script>

    <!-- TARGET HOTEL: Quill.js Rich Text Editor -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <style>
        body { background-color: #050505; color: #00ffcc; font-family: 'Courier New', Courier, monospace; padding: 40px; line-height: 1.6; }
        h1 { border-bottom: 2px solid #00ffcc; padding-bottom: 10px; text-transform: uppercase; letter-spacing: 2px; }
        .admin-panel { border: 1px solid #333; padding: 20px; background: #0a0a0a; margin-bottom: 30px; position: relative; }
        .admin-panel::before { content: "SYSTEM ACCESS"; position: absolute; top: -10px; left: 10px; background: #050505; padding: 0 5px; font-size: 0.7em; color: #ffaa00; }
        input, select, button { background: #111; border: 1px solid #444; color: #00ffcc; padding: 10px; font-family: inherit; margin-bottom: 10px; }
        input[type="file"] { border: 1px dashed #0055ff; background: #080808; cursor: pointer; }
        button { cursor: pointer; background: #00ffcc; color: #000; font-weight: bold; border: none; padding: 10px 25px; transition: 0.2s; }
        button:hover { background: #fff; transform: scale(1.05); }

        .badge { padding: 3px 8px; border-radius: 3px; font-size: 0.7em; text-transform: uppercase; font-weight: bold; margin-left: 10px; }
        .status-live { background: #00ff66; color: #000; }
        .status-dev { background: #ffaa00; color: #000; }
        #system-message, #login-error { color: #ffaa00; font-size: 0.9em; margin-bottom: 10px; }
        .action-buttons { margin-top: 15px; border-top: 1px dashed #333; padding-top: 10px; }

        #data-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 25px; margin-top: 20px; }
        .game-card { background: #0d0d0d; border: 1px solid #222; border-radius: 6px; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 4px 15px rgba(0,255,204,0.05); }

        .game-viewport { width: 100%; height: 220px; border-bottom: 2px solid #00ffcc; background-color: #111; object-fit: cover; }
        model-viewer { --poster-color: transparent; }

        .game-content { padding: 20px; flex-grow: 1; }

        .hud-panel { display: flex; justify-content: space-between; background: #080808; border: 1px dashed #333; padding: 15px; margin-bottom: 30px; border-left: 3px solid #ffaa00; }
        .hud-stat { text-align: center; flex: 1; border-right: 1px solid #222; }
        .hud-stat:last-child { border-right: none; }
        .hud-label { display: block; color: #555; font-size: 0.7em; letter-spacing: 2px; }
        .hud-value { display: block; color: #00ffcc; font-size: 2em; font-weight: bold; margin-top: 5px; }

        /* TARGET HOTEL: Custom Hacker Styles for the Quill Editor */
        #editor-container { height: 150px; background: #111; color: #00ffcc; border: 1px solid #444; font-family: 'Courier New', Courier, monospace; margin-bottom: 15px; }
        .ql-toolbar.ql-snow { background: #222; border: 1px solid #444; }
        .ql-snow .ql-stroke { stroke: #00ffcc; }
        .ql-snow .ql-fill { fill: #00ffcc; }
        .ql-snow .ql-picker { color: #00ffcc; }

        .game-lore { font-size: 0.85em; color: #bbb; border-left: 2px solid #444; padding-left: 10px; margin-top: 15px; max-height: 150px; overflow-y: auto; }

        #login-section { max-width: 400px; margin: 100px auto; text-align: center; }
        #dashboard-section { display: none; }
    </style>
</head>
<body>

    <div id="login-section" class="admin-panel">
        <h2>>> IDENTIFY</h2>
        <form id="login-form">
            <input type="email" id="login-email" placeholder="Admin Email" style="width: 90%;" required>
            <input type="password" id="login-password" placeholder="Passcode" style="width: 90%;" required>
            <button type="submit" style="width: 95%; margin-top: 10px;">AUTHENTICATE</button>
        </form>
        <div id="login-error"></div>
    </div>

    <div id="dashboard-section">
        <h1>NEXUS CORE // VISUAL COMMAND</h1>

        <div class="hud-panel" id="intel-hud">
            <div class="hud-stat"><span class="hud-label">TOTAL_PROJECTS</span><span class="hud-value" id="hud-projects">0</span></div>
            <div class="hud-stat"><span class="hud-label">LIVE_STATUS</span><span class="hud-value" id="hud-live">0</span></div>
            <div class="hud-stat"><span class="hud-label">IN_DEVELOPMENT</span><span class="hud-value" id="hud-dev">0</span></div>
            <div class="hud-stat"><span class="hud-label">TOTAL_OPERATIVES</span><span class="hud-value" id="hud-ops">0</span></div>
        </div>

        <div class="admin-panel">
            <div id="system-message">>> SYSTEM READY. WELCOME, COMMANDER.</div>

            <form id="add-game-form">
                <input type="text" id="title" placeholder="Project Title" required style="width: 30%;">
                <input type="text" id="studio" placeholder="Studio Designation" required style="width: 30%;">
                <select id="status" style="width: 30%;">
                    <option value="in-development">In-Development</option>
                    <option value="live">Live</option>
                </select>

                <!-- TARGET HOTEL: The Rich Text Editor UI -->
                <p style="margin: 15px 0 5px 0; color: #888; font-size: 0.8em;">>> DEEP LORE ARCHIVE (RICHTEXT):</p>
                <div id="editor-container"></div>

                <p style="margin: 15px 0 5px 0; color: #888; font-size: 0.8em;">>> ATTACH VISUAL ASSET (Image or .glb Model):</p>
                <input type="file" id="cover-image" accept="image/*,.glb" style="width: 93%;">
                <div id="dynamic-operatives"></div>
                <button type="submit" style="display: block; margin-top: 15px;">EXECUTE INJECTION</button>
            </form>

            <hr style="border: 0; border-top: 1px solid #222; margin: 20px 0;">

            <form id="add-char-form">
                <select id="char-game-id" required></select>
                <input type="text" id="char-name" placeholder="Operative Name" required>
                <input type="text" id="char-class" placeholder="Class" required>
                <button type="submit" style="background: #ffaa00;">RECRUIT</button>
            </form>
        </div>

        <input type="text" id="search-input" placeholder="SEARCH ENTIRE DATABASE..." style="width: 98%; padding: 15px;">
        <div id="data-container">ACCESSING CORE...</div>
    </div>

    <script>
        let allGames = [];
        let authToken = '';

        // TARGET HOTEL: Initialize the Quill Editor
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            placeholder: 'Enter secure deep lore here...',
            modules: { toolbar: [ ['bold', 'italic', 'underline'], [{ 'list': 'ordered'}, { 'list': 'bullet' }] ] }
        });

        document.getElementById('login-form').addEventListener('submit', function(e) {
            e.preventDefault();
            document.getElementById('login-error').innerText = ">> VERIFYING...";
            fetch('/api/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ email: document.getElementById('login-email').value, password: document.getElementById('login-password').value })
            }).then(res => res.json()).then(data => {
                if(data.token) {
                    authToken = data.token;
                    document.getElementById('login-section').style.display = 'none';
                    document.getElementById('dashboard-section').style.display = 'block';
                    fetchCoreData();
                } else { document.getElementById('login-error').innerText = ">> ACCESS DENIED."; }
            });
        });

        function getSecureHeadersForFiles() { return { 'Accept': 'application/json', 'Authorization': 'Bearer ' + authToken }; }
        function getSecureHeadersForJSON() { return { 'Content-Type': 'application/json', 'Accept': 'application/json', 'Authorization': 'Bearer ' + authToken }; }

        function fetchCoreData() {
            fetch('/api/games').then(res => res.json()).then(data => {
                allGames = data.data; renderGames(allGames); populateDropdown(allGames); updateHUD();
            });
        }

        function updateHUD() {
            document.getElementById('hud-projects').innerText = allGames.length;
            document.getElementById('hud-live').innerText = allGames.filter(g => g.status === 'live').length;
            document.getElementById('hud-dev').innerText = allGames.filter(g => g.status === 'in-development').length;
            let totalOps = 0; allGames.forEach(g => { if(g.characters) totalOps += g.characters.length; });
            document.getElementById('hud-ops').innerText = totalOps;
        }

        function populateDropdown(games) {
            const selector = document.getElementById('char-game-id');
            selector.innerHTML = '<option value="">SELECT TARGET GAME...</option>';
            games.forEach(g => selector.innerHTML += `<option value="${g.id}">${g.title}</option>`);
        }

        function renderGames(games) {
            const container = document.getElementById('data-container');
            container.innerHTML = games.length ? '' : '>> NO RECORDS FOUND.';

            games.forEach(game => {
                const badgeClass = game.status === 'live' ? 'status-live' : 'status-dev';
                const charCount = game.characters ? game.characters.length : 0;
                const imageUrl = game.cover_image ? `/storage/${game.cover_image}` : 'https://via.placeholder.com/400x200/111111/00ffcc?text=NO+VISUAL+DATA';

                let mediaHtml = '';
                if (game.cover_image && game.cover_image.endsWith('.glb')) {
                    mediaHtml = `<model-viewer src="${imageUrl}" auto-rotate camera-controls class="game-viewport" alt="3D Model of ${game.title}"></model-viewer>`;
                } else { mediaHtml = `<img src="${imageUrl}" class="game-viewport" alt="${game.title} Cover">`; }

                // TARGET HOTEL: Render the Deep Lore if it exists
                let loreHtml = game.lore_description ? `<div class="game-lore">${game.lore_description}</div>` : '';

                let html = `
                    <div class="game-card">
                        ${mediaHtml}
                        <div class="game-content">
                            <span style="float:right; color:#555; font-size:0.8em;">OPS: ${charCount}</span>
                            <h2 style="margin-top: 0;">${game.title}</h2>
                            <span class="badge ${badgeClass}" style="margin-left:0;">${game.status}</span>
                            <p style="color: #888; font-size: 0.9em; margin-bottom: 5px;">ORIGIN: ${game.studio_name}</p>

                            ${loreHtml}

                            <hr style="border: 0; border-top: 1px dashed #333; margin: 15px 0;">
                `;

                if(charCount > 0) {
                    html += `<ul style="color: #ccc; font-size: 0.9em; padding-left: 20px; margin-top: 0;">`;
                    game.characters.forEach(c => html += `<li><strong>${c.name}</strong> - ${c.class_type}</li>`);
                    html += `</ul>`;
                } else { html += `<p style="color: #444; font-style: italic; font-size: 0.9em; margin-top: 0;">No operatives registered.</p>`; }

                html += `
                            <div class="action-buttons">
                                <button onclick="editGame(${game.id})" style="background: #0055ff; padding: 5px 10px; font-size: 0.7em; color: white;">MODIFY</button>
                                <button onclick="deleteGame(${game.id})" style="background: #ff0033; padding: 5px 10px; font-size: 0.7em; color: white;">PURGE</button>
                            </div>
                        </div>
                    </div>
                `;
                container.innerHTML += html;
            });
        }

        document.getElementById('add-game-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const editId = this.dataset.editId;
            const url = editId ? `/api/games/${editId}` : '/api/games';
            const formData = new FormData();

            if (editId) { formData.append('_method', 'PUT'); }
            formData.append('title', document.getElementById('title').value);
            formData.append('studio_name', document.getElementById('studio').value);
            formData.append('status', document.getElementById('status').value);

            // TARGET HOTEL: Grab the HTML content from the Quill editor and send it!
            const loreHtml = quill.root.innerHTML;
            if (quill.getText().trim() !== '') { formData.append('lore_description', loreHtml); }

            const imageFile = document.getElementById('cover-image').files[0];
            if (imageFile) { formData.append('cover_image', imageFile); }

            if (editId) {
                let index = 0;
                document.querySelectorAll('.edit-char-row').forEach(row => {
                    formData.append(`characters[${index}][id]`, row.dataset.id);
                    formData.append(`characters[${index}][name]`, row.querySelector('.edit-char-name').value);
                    formData.append(`characters[${index}][class_type]`, row.querySelector('.edit-char-class').value);
                    index++;
                });
            }

            fetch(url, { method: 'POST', headers: getSecureHeadersForFiles(), body: formData })
            .then(res => res.json()).then(data => {
                this.reset();
                quill.root.innerHTML = ''; // Clear the editor!
                delete this.dataset.editId;
                document.getElementById('dynamic-operatives').innerHTML = '';
                const btn = this.querySelector('button'); btn.innerText = "EXECUTE INJECTION"; btn.style.background = "#00ffcc"; btn.style.color = "#000";
                document.getElementById('system-message').innerText = ">> DATABASE UPDATED.";
                fetchCoreData();
            });
        });

        window.editGame = function(id) {
            const game = allGames.find(g => g.id === id);
            document.getElementById('title').value = game.title;
            document.getElementById('studio').value = game.studio_name;
            document.getElementById('status').value = game.status;
            document.getElementById('cover-image').value = '';

            // TARGET HOTEL: Load the saved lore back into the editor!
            quill.root.innerHTML = game.lore_description || '';

            const opsContainer = document.getElementById('dynamic-operatives');
            opsContainer.innerHTML = '';
            if (game.characters && game.characters.length > 0) {
                opsContainer.innerHTML = '<p style="color: #0055ff; font-weight: bold; margin-bottom: 5px;">>> EDIT OPERATIVES:</p>';
                game.characters.forEach(c => {
                    opsContainer.innerHTML += `<div class="edit-char-row" data-id="${c.id}" style="display:flex; gap:10px; margin-bottom:5px;"><input type="text" class="edit-char-name" value="${c.name}" style="flex:1;"><input type="text" class="edit-char-class" value="${c.class_type}" style="flex:1;"></div>`;
                });
            }
            const form = document.getElementById('add-game-form');
            form.dataset.editId = id;
            const btn = form.querySelector('button'); btn.innerText = "UPDATE ENTIRE RECORD"; btn.style.background = "#0055ff"; btn.style.color = "white";
            window.scrollTo(0, 0);
        };

        window.deleteGame = function(id) {
            if(confirm("WARNING: Purge this lore record?")) {
                fetch(`/api/games/${id}`, { method: 'DELETE', headers: getSecureHeadersForJSON() }).then(() => fetchCoreData());
            }
        };

        document.getElementById('add-char-form').addEventListener('submit', function(e) {
            e.preventDefault();
            fetch('/api/characters', { method: 'POST', headers: getSecureHeadersForJSON(), body: JSON.stringify({ game_id: document.getElementById('char-game-id').value, name: document.getElementById('char-name').value, class_type: document.getElementById('char-class').value })
            }).then(() => { this.reset(); fetchCoreData(); });
        });

        document.getElementById('search-input').addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase();
            renderGames(allGames.filter(g => g.title.toLowerCase().includes(query) || g.studio_name.toLowerCase().includes(query)));
        });
    </script>
</body>
</html>
