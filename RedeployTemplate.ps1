#######################################################
#
# by Jose Moreno, November 2017
# Downloads a DSC file from Github and compiles it
# Ideally triggered from Github with a Webhook
#
#######################################################


# Variables
$connectionName = "AzureRunAsConnection"
$subName = "Microsoft Azure Internal Consumption"
$rg = "iacLab"
$templateUrl = "https://raw.githubusercontent.com/erjosito/IaC-Test/master/IaCLab_vnet_test.json"

# Log into Azure with a Connection
try {
    # Get the connection "AzureRunAsConnection "
    $servicePrincipalConnection=Get-AutomationConnection -Name $connectionName         
    Write-Output ("Logging in to Azure...")
    Add-AzureRmAccount `
        -ServicePrincipal `
        -TenantId $servicePrincipalConnection.TenantId `
        -ApplicationId $servicePrincipalConnection.ApplicationId `
        -CertificateThumbprint $servicePrincipalConnection.CertificateThumbprint `
        -SubscriptionName $subName
} catch {
    if (!$servicePrincipalConnection)
    {
        $ErrorMessage = "Connection $connectionName not found."
        throw $ErrorMessage
    } else{
        Write-Error -Message $_.Exception
        throw $_.Exception
    }
}

# Check that the resource group exists
$myRg = Get-AzureRmResourceGroup -Name $rg -ErrorAction SilentlyContinue
if ($myRg) {
    Write-Output ("Resource group '" + $rg + "' found in subscription '" + $subName + "'")
} else {
    Write-Output ("Resource group '" + $rg + "' could not be found in subscription '" + $subName + "'")    
    Exit
}

# Deploy template
Write-Output ("Redeploying template from URL " + $templateUrl)
New-AzureRmResourceGroupDeployment -Mode Complete -ResourceGroupName $rg -TemplateParameterUri $templateUrl