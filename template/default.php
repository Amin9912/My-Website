<?php include(__DIR__.'/../component/header.php'); ?>

<body class="d-flex flex-column h-100">
    <?php include(__DIR__.'/../component/nav_shared.php'); ?>
    <main class="flex-shrink-0">
        <div class="container mt-5">
            <?php echo $content ?? ''; ?>
        </div>
    </main>
    <?php include(__DIR__.'/../component/footer.php'); ?>
</body>

</html>

<script src="/UTM/assets/admin/admin.js"></script>