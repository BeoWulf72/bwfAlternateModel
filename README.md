#bwfAlternateModel

##Usage

```php

$csv_data = array(
  array('id', 'name', 'count'),
  //...
);

$model = $this->getServiceLocator('bwfCsvModel');
return $model($csv_data);
```

=================