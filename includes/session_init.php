<?php
require_once __DIR__ . '/session.php';
?>
<script>
window.isLoggedIn = <?php echo isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true ? 'true' : 'false'; ?>;
</script> 