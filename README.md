# ABO generator for PHP

## Installation
Install gondik/abo using  [Composer](http://getcomposer.org/):

```sh
$ composer require gondk/abo
```

### Dependencies
- PHP >=5.6

## Example Usage
```
use Gondik\Abo\Abo;
use Gondik\Abo\Account\File;

$abo = new Abo();
$abo->setComittentNumer(222780978);
$abo->setOrganization("Abs s.r.o.");
$abo->setDate('271198');
$account = $abo->addAccountFile(File::INKASO);
$account->setBank('0300'); // kod banky, ktera bude zpracovavat (ta nase)
$group = $account->addGroup();
$group->setAccount(122780922);
$group->setDate('271198');
$group->addItem("174-1999738514/0300", 2000.5, 2220009813)
	->setConstSym('8')
	->setSpecSym('93653')
	->setMessage('message');

$group->addItem("5152046/0300", 2000, 2220000598)
	->setConstSym('8')
	->setSpecSym('93654');

$group->addItem("192359658/0300", 2000, 2220000004)
	->setConstSym('8')		
	->setSpecSym('93655');

$group->addItem("174-0346006514/0300", 2000, 2220497222)
	->setConstSym('8')
	->setSpecSym('93656')
	->setMessage('message');
	
$group->addItem("492732514/0300", 2000, 2220000811)
	->setConstSym('8')
	->setSpecSym('93657');

echo $abo->generate();
