<?php

declare(strict_types=1);

namespace Lle\CruditBundle\Dto\Layout;

use Lle\CruditBundle\Dto\Badge;
use Lle\CruditBundle\Dto\Icon;
use Lle\CruditBundle\Dto\Path;

class LinkElement extends AbstractLayoutElement
{
    public const TYPE_HEADER = 'header';
    public const TYPE_BODY = 'body';

    /** @var string */
    protected $type;

    /** @var string */
    protected $libelle;

    /** @var ?Icon */
    protected $icon;

    /** @var Path  */
    protected $path;

    /** @var Badge[]  */
    protected $badges;

    /** @var string */
    protected $cssClass;

    /** @var LinkElement[] */
    protected $children;

    public static function new(string $libelle, ?Path $path, ?Icon $icon = null, ?string $role = null): self
    {
        $item = new self($libelle, $path, $icon, $role);
        $item->setId(str_replace('menu.', '', $libelle));

        return $item;
    }

    public function getTemplate(): string
    {
        return '@LleCrudit/layout/sb_admin/elements/_link.html.twig';
    }

    public function __construct(string $libelle, ?Path $path, ?Icon $icon = null, ?string $role = null)
    {
        $this->libelle = $libelle;
        $this->icon = $icon;
        $this->path = $path;
        $this->role = $role;
        $this->badges = [];
        $this->children = [];
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;
        return $this;
    }

    public function getIcon(): ?Icon
    {
        return $this->icon;
    }

    public function setIcon(Icon $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    public function getPath(): ?Path
    {
        return $this->path;
    }

    public function setPath(Path $path): self
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return Badge[]
     */
    public function getBadges(): ?array
    {
        return $this->badges;
    }

    public function addBadge(Badge $badge): self
    {
        $this->badges[] = $badge;
        return $this;
    }

    public function add(self $element): void
    {
        $this->children[] = $element;
    }
}
