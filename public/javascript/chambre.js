document.addEventListener("DOMContentLoaded", () => {
  splide2.mount();
  const notifications = document.querySelectorAll(".notif");
  notifications.forEach((notification, index) => {
    setTimeout(() => {
      notification.remove();
    }, 8000);
    const closeIcons = document.querySelectorAll(".close");
    closeIcons.forEach((icon) => {
      icon.addEventListener("click", () => {
        notification.remove();
      });
    });
  });
});
