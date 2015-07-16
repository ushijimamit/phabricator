<?php

final class DiffusionCommitDiffContentRemovedHeraldField
  extends DiffusionCommitHeraldField {

  const FIELDCONST = 'diffusion.commit.diff.old';

  public function getHeraldFieldName() {
    return pht('Diff content removed');
  }

  public function getHeraldFieldValue($object) {
    return $this->getAdapter()->loadDiffContent('-');
  }

  protected function getHeraldFieldStandardType() {
    return self::STANDARD_TEXT_MAP;
  }

}