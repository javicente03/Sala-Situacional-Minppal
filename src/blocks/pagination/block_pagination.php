<nav aria-label="Page navigation">
    <?php  unset($_GET['page']); ?>

    <ul class="pagination justify-content-center">
        <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
        <?php if (count($_GET) > 0) { ?>
            <a class="page-link" href="<?php echo $page <= 1 ? '#' : '?page=' . ($page - 1) . '&' . http_build_query($_GET); ?>" tabindex="-1">Anterior</a>
        <?php } else { ?>
            <a class="page-link" href="<?php echo $page <= 1 ? '#' : '?page=' . ($page - 1); ?>" tabindex="-1">Anterior</a>
        <?php } ?>
        </li>
        <?php
        // Total number of pages

        // Number of pages to display in pagination
        $numPages = 5;

        // Start and end pages of pagination
        $startPage = max($page - floor($numPages / 2), 1);
        $endPage = min($startPage + $numPages - 1, $totalPages);

        // Generate pagination links
        for ($i = $startPage; $i <= $endPage; $i++) {
        $activeClass = $page == $i ? 'active' : '';
            
            if (count($_GET) > 0) {
                $query = http_build_query($_GET);
                echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . '&' . $query . '">' . $i . '</a></li>';
            } else {
                echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
            }
        }

        ?>
        <li class="page-item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">
        <?php if (count($_GET) > 0) { ?>
            <a class="page-link" href="<?php echo $page >= $totalPages ? '#' : '?page=' . ($page + 1) . '&' . http_build_query($_GET); ?>">Siguiente</a>
        <?php } else { ?>
            <a class="page-link" href="<?php echo $page >= $totalPages ? '#' : '?page=' . ($page + 1); ?>">Siguiente</a>
        <?php } ?>
        </li>
    </ul>
</nav>