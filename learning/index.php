<html>
    <head>
        <link href="../css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <?php
            error_reporting(E_ALL);
            ini_set("display_errors", 'On');
        ?>
        <esi:include src="include/header.php"></esi:include>
        <esi:remove>
            <b>From Normal</b>
            <?php include "include/header.php"; ?>
        </esi:remove>

        <div id="sidebar-content">
            <?php
                session_start();
            ?>
            <!-- Left Sidebar -->
            <esi:include src="include/left-side.php" />
            <esi:remove>
                <b>From Normal</b>
                <?php include "include/left-side.php"; ?>
            </esi:remove>

            <!-- Content -->
            <esi:include src="include/content.php" />
            <esi:remove>
                <b>From Normal</b>
                <?php include "include/content.php"; ?>
            </esi:remove>

            <!-- Right Sidebar -->
            <esi:include src="include/right-side.php" />
            <!-- esi <esi:include src="include/right-side.php" /> -->
        </div>
        <!-- Footer -->
        <esi:include src="include/footer.php" />
        <esi:remove>
            <b>From Normal</b>
            <?php include "include/footer.php"; ?>
        </esi:remove>
    </body>
</html>
