self.addEventListener('push', event => {
    const data = event.data.json();
    const { title, body, icon, data: payload } = data;

    event.waitUntil(
        self.registration.showNotification(title, {
        body,
        icon: icon || '/favicon.ico',
        data: payload,
        })
    );
    });

    self.addEventListener('notificationclick', event => {
    event.notification.close();
    const url = event.notification.data.url || '/';
    event.waitUntil(clients.openWindow(url));
    });
