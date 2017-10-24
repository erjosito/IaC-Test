<html>
   <header>
     <title>Linux VM</title>
   </header>
   <body>
     <h1>
       Welcome to my humble VM
     </h1>
    <p>Some info about me...</p>
     <br>
     <ul>
     <?php
        $hostname = exec('hostname');
        echo "<li>Name: " . $hostname . "</li>\n";
        echo "<li>IP address: " . $_SERVER['SERVER_ADDR'] . "</li>\n";
        echo "<li>Software: " . $_SERVER['SERVER_SOFTWARE'] . "</li>\n";
        $pip = exec('curl ifconfig');
        echo "<li>Name: " . $pip . "</li>\n";
        ?>
     </ul>
     <br>
     <p>Information retrieved out of the public IP</p>
     <?php
            $cmd = "curl freegeoip.net/json/" . $pip;
            $locationInfo = shell_exec($cmd);
            $location = json_decode($locationInfo, true);
            $country = $location["country_name"];
            $region = $location["region_name"];
            $city = $location["city"];
    ?>
    <ul>
        <li>Country: <?php print ($country); ?></li>
        <li>Region: <?php print ($region); ?></li>
        <li>City: <?php print ($city); ?></li>
    </ul>
    <br>
     <p>Information retrieved out of the instance metadata</p>
    <?php
        # Example output: lab-user@myvm:~$ curl -H Metadata:true http://169.254.169.254/metadata/instance?api-version=2017-08-01
        # {"compute":{"location":"westeurope","name":"myvm-az-1","offer":"UbuntuServer","osType":"Linux","placementGroupId":"","platformFaultDomain":"0","platformUpdateDomain":"0","publisher":"Canonical","resourceGroupName":"iaclab","sku":"16.04.0-LTS","subscriptionId":"e7da9914-9b05-4891-893c-546cb7b0422e","tags":"","version":"16.04.201611150","vmId":"8b9edb1b-ed22-4e0f-bee3-9e880e46258e","vmSize":"Standard_D2_v2"},"network":{"interface":[{"ipv4":{"ipAddress":[{"privateIpAddress":"10.1.1.5","publicIpAddress":""}],"subnet":[{"address":"10.1.1.0","prefix":"24"}]},"ipv6":{"ipAddress":[]},"macAddress":"000D3A2589D0"}]}}
        $cmd = "curl -H Metadata:true http://169.254.169.254/metadata/instance?api-version=2017-08-01";
        $metadataJson = shell_exec($cmd);
        $metadata = json_decode($metadataJson, true);
        $metaloc = $metadata["compute"]["location"];
        $metapfd = $metadata["compute"]["platformFaultDomain"];
        $metapud = $metadata["compute"]["platformUpdateDomain"];
        $metasub = $metadata["compute"]["subscriptionId"];
        $metavms = $metadata["compute"]["vmSize"];
        $metapub = $metadata["compute"]["publisher"];
        $metaoff = $metadata["compute"]["offer"];
        $metasku = $metadata["compute"]["sku"];
    ?>
    <ul>
        <li>Location: <?php print ($metaloc); ?></li>
        <li>Fault Domain: <?php print ($metapfd); ?></li>
        <li>Update Domain: <?php print ($metapud); ?></li>
        <li>Subscription ID: <?php print ($metasub); ?></li>
        <li>VM Size: <?php print ($metavms); ?></li>
        <li>Publisher: <?php print ($metapub); ?></li>
        <li>Offer: <?php print ($metaoff); ?></li>
        <li>SKU: <?php print ($metasku); ?></li>
    </ul>
   </body>
</html>
