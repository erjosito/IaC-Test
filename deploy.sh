az group deployment create --name iacLabDeployment --template-uri https://raw.githubusercontent.com/erjosito/Iac-Test/master/IaCLab\_master.json --parameters @./IaCLab-parameters.json -g iaclab
duration=$SECONDS
echo "$(($duration / 60)) minutes and $(($duration % 60)) seconds elapsed."
