<footer class="site-footer">
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
        <span class="footer-brand">Конференции<span class="brand-dot">.рф</span></span>

        <?php if (!empty($isAdmin)): ?>
            <span class="footer-admin-label">Вы находитесь в админ-панели</span>
            <a href="logout.php" class="btn btn-logout btn-sm">Выход</a>
        <?php elseif (!empty($isLoggedIn)): ?>
            <span class="footer-copy">© 2026 Конференции.рф — личный кабинет клиента</span>
            <span class="footer-contacts">
                Поддержка: <a href="mailto:support@конференции.рф">support@конференции.рф</a>
            </span>
        <?php else: ?>
            <span class="footer-copy">© 2026 Конференции.рф — бронирование залов для деловых мероприятий</span>
            <span class="footer-contacts">info@конференции.рф · +7 (495) 000-00-00</span>
        <?php endif; ?>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/slider.js"></script>
<script src="js/footer.js"></script>
</body>
</html>