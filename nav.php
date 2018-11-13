<!-- ######################     Main Navigation   ########################## -->
<nav>
    <ol>
        <?php
        // This sets a class for current page so you can style it differently
        
        print '<li ';
        if ($PATH_PARTS['filename'] == 'lab5 Home') {
            print ' class="activePage" ';
        }
        print '><a href="index.php">Home Lab5</a></li>';
        
        print '<li ';
        if ($PATH_PARTS['filename'] == 'sitemap') {
            print ' class="activePage" ';
        }
        print '><a href="../sitemap.php">Sitemap</a></li>';
       
        print '<li ';
        if ($PATH_PARTS['filename'] == 'Form') {
            print ' class="activePage" ';
        }
        print '><a href="form.php">Form</a></li>';
        
        print '<li ';
        if ($PATH_PARTS['filename'] == 'tables') {
            print ' class="activePage" ';
        }
        print '><a href="tables.php">Tables</a></li>';

        ?>
    </ol>
</nav>
<!-- #################### Ends Main Navigation    ########################## -->

