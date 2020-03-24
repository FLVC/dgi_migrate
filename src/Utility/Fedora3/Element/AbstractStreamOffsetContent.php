<?php

namespace Drupal\dgi_migrate\Utility\Fedora3\Element;

use Drupal\dgi_migrate\Utility\Fedora3\AbstractParser;
use Drupal\dgi_migrate\Utility\Fedora3\FoxmlParser;

abstract class AbstractStreamOffsetContent extends AbstractParser {
  protected $start;
  protected $end;
  protected $target;

  public function __construct($parser, $attributes) {
    parent::__construct($parser, $attributes);

    $this->target = $this->foxmlParser->getTarget();
    $this->start = $this->foxmlParser->getOffset();
  }

  public function start() {
    return $this->start;
  }
  public function end() {
    return $this->end;
  }
  public function length() {
    return $this->end - $this->start;
  }
  protected function updateEnd() {
    $this->end = $this->foxmlParser->getOffset();
  }

  public function tagOpen($parser, $tag, $attributes) {
    $this->updateEnd();
  }
  public function tagClose($parser, $tag) {
    $this->updateEnd();
  }
  public function characters($parser, $chars) {
    $this->updateEnd();
  }

  public function getUri() {
    return "php://filter/read=dgi_migrate_substream.{$this->start()}.{$this->end()}/resource={$this->target}";
  }
}
