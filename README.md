## Using the PHP-DNS class

```php
<?php $Hostname = new DNS("example.com"); ?>
```

**Retrieve the domainname:**
```php
  <?php echo $Hostname->get_hostname(); ?>
```

**Retrieve all the DNS records:**
```php
  <?php print_r($Hostname->get_records()); ?>
```
  
**Only retrive the 'A' records from the DNS server:**
```php
  <?php print_r($Hostname->get_records('A')); ?>
```
  
**Retrieve only the 'A' and 'MX' records from the DNS server:**
```php
  <?php print_r($Hostname->get_records('A', 'MX')); ?>
```