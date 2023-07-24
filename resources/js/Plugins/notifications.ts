import { router, usePage } from '@inertiajs/vue3';
import { TYPE, useToast } from 'vue-toastification';

const toast = useToast();

interface Notification {
    body: string,
    type: TYPE,
}

export const notifications = () => {
    router.on('finish', () => {
        const notification: Notification = usePage().props.notification as Notification;

        if (notification.body && notification.type) {
            toast(notification.body, { type: notification.type });
        }
    });
};
