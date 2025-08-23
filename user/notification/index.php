<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
           <link rel="icon" type="image/png" href="../../images/logo.png">

    <link rel="stylesheet" href="index.css">
</head>
<body>
    <!-- Top Navigation -->
   <?php include 'navbar.php'?>
    <!-- Main Container -->
     <br><br>
    <div class="container">
        <div id="alert-container"></div>
        <div id="notification-list"></div>
        <div id="loading" class="loading">
            <span class="spinner"></span> No Sakalee...
        </div>
        <div id="pagination" class="pagination"></div>
    </div>

    <!-- Footer -->
     <br><br><br><br><br><br><br><br>
                      <?php include '../../include/app_settings.php'; ?>
        <footer style="text-align:center; font-size:14px; color:var(--secondary-color); background-color:var(--primary-color); padding:20px 0;">
            <?php echo APP_NAME_FOOTER; ?>
        </footer>

    <script>
        let currentPage = 1;
        const perPage = 10;

        // Fetch notifications
        function fetchNotifications(page = 1) {
            document.getElementById('loading').style.display = 'flex';
            document.getElementById('notification-list').style.display = 'none';

            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=get_notifications&page=' + encodeURIComponent(page) +
                      '&csrf_token=' + encodeURIComponent('<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>')
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderNotifications(data.data.notifications);
                    renderPagination(data.data.total, data.data.page);
                } else {
                    showAlert(data.message || 'Failed to load notifications', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Network error. Please try again.', 'error');
            })
            .finally(() => {
                document.getElementById('loading').style.display = 'none';
                document.getElementById('notification-list').style.display = 'block';
            });
        }

        // Render notifications
        function renderNotifications(notifications) {
            const container = document.getElementById('notification-list');
            if (notifications.length === 0) {
                container.innerHTML = '<div class="empty-state">No notifications available</div>';
                return;
            }

            container.innerHTML = notifications.map(notification => `
                <div class="notification-card ${notification.read ? '' : 'unread'}" data-id="${notification.id}">
                    <div class="notification-header">
                        <div class="notification-title">${notification.title}</div>
                        <div class="notification-date">${new Date(notification.date).toLocaleString()}</div>
                    </div>
                    <div class="notification-message">${notification.message}</div>
                    <div class="notification-actions">
                        ${!notification.read ? `<button class="mark-read-btn" onclick="markRead(${notification.id})">Mark as Read</button>` : ''}
                    </div>
                </div>
            `).join('');
        }

        // Render pagination
        function renderPagination(total, current) {
            const totalPages = Math.ceil(total / perPage);
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = '';

            if (totalPages <= 1) return;

            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement('button');
                btn.className = `page-btn ${i === current ? 'active' : ''}`;
                btn.textContent = i;
                btn.disabled = i === current;
                btn.addEventListener('click', () => {
                    currentPage = i;
                    fetchNotifications(i);
                });
                pagination.appendChild(btn);
            }
        }

        // Mark notification as read
        function markRead(id) {
            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=mark_read&id=' + encodeURIComponent(id) +
                      '&csrf_token=' + encodeURIComponent('<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>')
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');
                    fetchNotifications(currentPage);
                } else {
                    showAlert(data.message || 'Failed to mark as read', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Network error. Please try again.', 'error');
            });
        }

        // Mark all notifications as read
        function markAllRead() {
            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=mark_all_read&csrf_token=' + encodeURIComponent('<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>')
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');
                    fetchNotifications(currentPage);
                } else {
                    showAlert(data.message || 'Failed to mark all as read', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Network error. Please try again.', 'error');
            });
        }

        // Show alert message
        function showAlert(message, type = 'error') {
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.innerHTML = message;
            const container = document.getElementById('alert-container');
            container.innerHTML = '';
            container.appendChild(alert);
            window.scrollTo({ top: 0, behavior: 'smooth' });
            setTimeout(() => alert.remove(), 5000);
        }

        // Go back function
        function goBack() {
            window.history.back();
        }

        // Initial load
        document.addEventListener('DOMContentLoaded', () => {
            fetchNotifications(currentPage);
        });
    </script>
</body>
</html>