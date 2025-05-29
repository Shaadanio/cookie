	<?php
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cookie_settings'])) {
			$settings = json_decode($_POST['cookie_settings'], true);

			if (!$settings['analytics']) {
				foreach ($_COOKIE as $name => $value) {
					if (preg_match('/^(_ga|_gid|_gat|ym_uid|_ym_)/', $name)) {
						setcookie($name, '', time() - 3600, '/');
					}
				}
			}

			if (!$settings['ads']) {
				foreach ($_COOKIE as $name => $value) {
					if (preg_match('/^(yandexuid|_fbp|fr|_gads|IDE|mgo_)/', $name)) {
						setcookie($name, '', time() - 3600, '/');
					}
				}
			}

			exit;
		}
		?>
		<style>
		#cookie-banner {
			position: fixed;
			bottom: 20px;
			right: 20px;
			width: 340px;
			background: white;
			border-radius: 12px;
			box-shadow: 0 4px 15px rgba(0,0,0,0.15);
			font-family: sans-serif;
			padding: 20px;
			font-size: 14px;
			z-index: 9999;
			display: none;
		}
		#cookie-banner h2 {
			font-size: 16px;
			margin: 0 0 10px;
		}
		.cookie-section {
			margin-bottom: 8px;
		}
		.cookie-section label {
			cursor: pointer;
		}
		.cookie-section input[type="checkbox"] {
			appearance: none;
			-webkit-appearance: none;
			width: 20px;
			height: 20px;
			border: 2px solid #ccc;
			border-radius: 6px;
			display: inline-block;
			position: relative;
			vertical-align: middle;
			cursor: pointer;
			transition: background 0.2s, border-color 0.2s;
			background-color: #fff;
			margin-right: 8px;
		}

		.cookie-section input[type="checkbox"]:checked {
			background-color: #4CAF50;
			border-color: #4CAF50;
		}

		.cookie-section input[type="checkbox"]:checked::after {
			content: '';
			position: absolute;
			left: 5px;
			top: 1px;
			width: 6px;
			height: 11px;
			border: solid #fff;
			border-width: 0 2px 2px 0;
			transform: rotate(45deg);
		}
		#cookie-banner button {
			background-color: #4CAF50;
			color: white;
			padding: 8px 14px;
			border: none;
			border-radius: 6px;
			cursor: pointer;
			font-size: 14px;
		}
		#cookie-banner button:hover {
			background-color: #43a047;
		}
		#cookie-settings {
			display: none;
			margin-top: 10px;
			margin: 0 0 15px;
		}
		#cookie-banner #toggle-settings {
			background: transparent;
			border: none;
			color: #545454;
			cursor: pointer;
			font-size: 14px;
			padding: 0;
    		margin: 10px 0 20px;
			display: flex;
		}
		#cookie-banner #toggle-settings svg{
			fill: #939393;
		}
		#cookie-banner p{
			font-size: 14px;
			color: #6c6c6c;
			margin: 0 0 7px;
		}
		#cookie-banner .ctitle{
			color: #000;
    		font-size: 16px;
		}
		#cookie-banner .cadd{
    		color: #000;
		}
		#cookie-banner a{
    		color: #01740b;
		}
		</style>

		<div id="cookie-banner">
			<p class="ctitle"><b>Настройки Cookie</b></p>
			<p>Наш сайт использует файлы cookie, чтобы улучшить работу сайта, повысить его эффективность и удобство.</p>
			<p>Продолжая использовать сайт, вы соглашаетесь на <a href="/politika-ispolzovaniya-cookie-fajlov/" target="_blank">использование файлов cookie.</a></p>
			<p class="cadd">Системные cookie необходимы для работы сайта и всегда включены.</p>
			<button id="toggle-settings" onclick="toggleSettings()">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#007BFF" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 6px;">
					<path d="M8 1a1 1 0 0 1 1 1v1.07a5.96 5.96 0 0 1 2.292.773l.76-.76a1 1 0 0 1 1.414 1.414l-.76.76A5.96 5.96 0 0 1 13.93 7H15a1 1 0 0 1 0 2h-1.07a5.96 5.96 0 0 1-.773 2.292l.76.76a1 1 0 0 1-1.414 1.414l-.76-.76A5.96 5.96 0 0 1 9 13.93V15a1 1 0 0 1-2 0v-1.07a5.96 5.96 0 0 1-2.292-.773l-.76.76a1 1 0 0 1-1.414-1.414l.76-.76A5.96 5.96 0 0 1 2.07 9H1a1 1 0 0 1 0-2h1.07a5.96 5.96 0 0 1 .773-2.292l-.76-.76a1 1 0 1 1 1.414-1.414l.76.76A5.96 5.96 0 0 1 7 3.07V2a1 1 0 0 1 1-1zm0 4a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
				</svg>
				Настроить
			</button>

			<div id="cookie-settings" style="display: none;">
				<div class="cookie-section">
					<input type="checkbox" id="analytics" checked>
					<label for="analytics">Аналитические cookie</label>
				</div>
				<div class="cookie-section">
					<input type="checkbox" id="ads" checked>
					<label for="ads">Рекламные cookie</label>
				</div>
			</div>
			<button onclick="submitCookieConsent()">Принять</button>
		</div>

		<script>
		function toggleSettings() {
			const settingsBlock = document.getElementById('cookie-settings');
			const sections = document.querySelectorAll('.cookie-section');
			if (settingsBlock.style.display === 'none') {
				settingsBlock.style.display = 'block';
				sections.forEach(el => el.style.display = 'block');
			} else {
				settingsBlock.style.display = 'none';
				sections.forEach(el => el.style.display = 'none');
			}
		}
		function submitCookieConsent() {
			const analytics = document.getElementById('analytics').checked;
			const ads = document.getElementById('ads').checked;

			const settings = { analytics: analytics, ads: ads };
			localStorage.setItem('cookieConsent', JSON.stringify(settings));
			document.getElementById('cookie-banner').style.display = 'none';

			// Отправляем настройки серверу для удаления куков
			fetch(location.href, {
				method: 'POST',
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
				body: 'cookie_settings=' + encodeURIComponent(JSON.stringify(settings))
			});
		}

		// Проверка при загрузке страницы
		window.addEventListener('DOMContentLoaded', () => {
			const saved = localStorage.getItem('cookieConsent');
			if (!saved) {
				document.getElementById('cookie-banner').style.display = 'block';
			} else {
				const settings = JSON.parse(saved);

				// Удаление куков, если пользователь не согласился
				if (!settings.analytics || !settings.ads) {
					fetch(location.href, {
						method: 'POST',
						headers: {'Content-Type': 'application/x-www-form-urlencoded'},
						body: 'cookie_settings=' + encodeURIComponent(JSON.stringify(settings))
					});
				}
			}
		});

		console.log('Cookie consent script loaded');
		console.log('Current cookie settings:', localStorage.getItem('cookieConsent'));
		</script>
