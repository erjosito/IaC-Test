<html>
   <header>
     <title>Linux VM</title>
   </header>
   <body>
     <h1>
       Welcome to the my humble VM
     </h1>
    <p>Some info about me...</p>
     <br>
     <ul>
     <?php
        echo "<li>Name: " . $_SERVER['SERVER_NAME'] . "</li>\n";
        echo "<li>IP address: " . $_SERVER['SERVER_ADDR'] . "</li>\n";
        echo "<li>Software: " . $_SERVER['SERVER_SOFTWARE'] . "</li>\n";
        ?>
     </ul>
   </body>
</html>
