<?php

declare(strict_types=1);

namespace Lle\CruditBundle\Brick\ListBrick;

use Lle\CruditBundle\Brick\AbstractBrickConfig;
use Lle\CruditBundle\Contracts\CrudConfigInterface;
use Lle\CruditBundle\Contracts\DatasourceInterface;
use Lle\CruditBundle\Dto\Action\ItemAction;
use Lle\CruditBundle\Dto\Field\Field;

class ListConfig extends AbstractBrickConfig
{

    /** @var Field[] */
    private $fields = [];

    /** @var array  */
    private $options;

    /** @var ItemAction[] */
    private $actions = [];

    /** @var DatasourceInterface */
    private $dataSource;

    public function setCrudConfig(CrudConfigInterface $crudConfig): self
    {
        parent::setCrudConfig($crudConfig);
        if ($this->dataSource === null) {
            $this->setDataSource($crudConfig->getDatasource());
        }
        return $this;
    }

    public static function new(array $options = []): self
    {
        return new self($options);
    }

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    public function setDataSource(DatasourceInterface $dataSource): self
    {
        $this->dataSource = $dataSource;
        return $this;
    }

    public function getDataSource(): ?DatasourceInterface
    {
        return $this->dataSource;
    }

    public function addAction(ItemAction $action): self
    {
        $this->actions[] = $action;
        return $this;
    }

    public function getActions(): array
    {
        return $this->actions;
    }

    public function getConfig(): array
    {
        return [
            'fields' => $this->getFields(),
            'actions' => $this->getActions(),
            'detail' => null,
            'hidden_action' => false,
            'bulk' => false,
            'sort' => ['name' => 'id', 'direction' => 'ASC'],
            'canModifyNbEntityPerPage' => false
        ];
    }

    public function addField(Field $field): self
    {
        $this->fields[] = $field;
        return $this;
    }

    public function add(string $name, string $type = null, array $options = []): self
    {
        return $this->addField(Field::new($name, $type, $options));
    }

    public function addAuto(array $columns): self
    {
        foreach ($columns as $column) {
            $this->addField(Field::new($column));
        }
        return $this;
    }

    /** @return Field[] */
    public function getFields(): array
    {
        return $this->fields;
    }
}