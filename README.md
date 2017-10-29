# ARM templates for Infrastructure as Code

This is an exercise to create advanced ARM templates to demonstrate the concept of Infrastructure as Code in Azure

## Nested templates

In order to provide modularity, the ARM templates in this repository make extensive use of the concept of nested templates. Here is the nesting scheme of the templates used:

* IaCLab_master.json: creates Vnet and calls the template to create VMs or VMSS.
  * vmLinux_1nic_noVnet.json: creates load balancers (if required) and VMs using Availability Sets or Availability Zones
    * vmNic.json: creates a nic, with or without public IP, with or without NSGs
    * slb.json: creates an external or internal load balancer
      * internalLB.json: creates internal LB
      * externalLB.json: creates external LB
  * vmss_Linux_1nic_noVnet.json: creates load balancers (if required) and VMSS using Availability Sets or Availability Zones
    * slb.json: creates an external or internal load balancer
      * internalLB.json: creates internal LB
      * externalLB.json: creates external LB


## Availability Zones

One of the parameters that the ARM templates can take is whether deploy the VMs/VMSSs in Availability Zones or not. This will causes many variables to take different values: public IPs and load balancers need to be standard (not basic), Availability Sets cannot be used, etc.

## Conditional value of variables

There are essentially two techniques in order to assign a different value to a variable depending on another one. For example, if you have the variable deployLBYesNo, and you want to declare the value lbSku as "basic" if deployLBYesNo="no", and "standard" if "deployLBYesNo"="yes", you have two options:
* Using dictionaries (sometimes called hash variables). You could define a dictionary variable "dict" as {"yes": "standard", "no": "basic"}, and then declare the variable "lbSku" as "dict"["deployLBYesNo"]
* Using conditional ARM functions, more specifically, the functions if and equals. You can declare the "lbSku" variable as if(equals(deployLBYesNo, "no"), "basic", "standard")

## Output variables

These ARM functions do not use output variables, mainly due to the fact that the outputs can be different depending on the parameters supplied. For example, you could return the LB virtual IP address as output variable, but what if the user decided not to create a Load balancer, by supplying the parameter deployLBYesNo=no?

## Examples using the main template

<pre lang="">
az group deployment create -g azlab --name azLabDeployment --template-uri https://raw.githubusercontent.com/erjosito/Iac-Test/master/IaCLab\_master.json --parameters '{ \
  "adminUsername":{"value":"lab-user"}, \
  "adminPassword":{"value":"yourSuperSecretPassword"}, \
  "vmType":{"value":"ubuntuScaleSet"}, \
  "vmSize":{"value":"Standard_D1_v2"}, \
  "CapacityMin":{"value": 1}, \
  "CapacityDef":{"value": 2}, \
  "CapacityMax":{"value": 4}, \
  "azYesNo":{"value":"yes"}, \
  "pipYesNo":{"value":"no"}, \
  "deployLBYesNo":{"value":"yes"}, \
  "lbType":{"value":"external"}, \
  "lbSku":{"value":"standard"}}'
</pre>