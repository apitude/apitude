<?php
namespace Apitude\Core\DBAL;

class Mysql57Platform extends \Doctrine\DBAL\Platforms\MySql57Platform
{
    public function getGuidTypeDeclarationSQL(array $field)
    {
        $field['length'] = 36;
        $field['fixed']  = true;
        $field['collation'] = 'ascii_general_ci';
        $field['charset'] = 'ascii';

        return $this->getVarcharTypeDeclarationSQL($field);
    }

    public function getVarcharTypeDeclarationSQL(array $field)
    {
        if ( !isset($field['length'])) {
            $field['length'] = $this->getVarcharDefaultLength();
        }

        $fixed = (isset($field['fixed'])) ? $field['fixed'] : false;

        if ($field['length'] > $this->getVarcharMaxLength()) {
            return $this->getClobTypeDeclarationSQL($field);
        }

        $snip =  $this->getVarcharTypeDeclarationSQLSnippet($field['length'], $fixed);

        if ( array_key_exists('collation', $field) ) {
            $snip .= " COLLATE {$field['collation']}";
        }

        return $snip;
    }
}
