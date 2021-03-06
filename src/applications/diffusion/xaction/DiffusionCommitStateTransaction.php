<?php

final class DiffusionCommitStateTransaction
  extends DiffusionCommitTransactionType {

  const TRANSACTIONTYPE = 'diffusion.commit.state';

  public function generateNewValue($object, $value) {
    // NOTE: This transaction can not be generated or applied normally. It is
    // written to the transaction log as a side effect of a state change.
    throw new PhutilMethodNotImplementedException();
  }

  private function getAuditStatusObject() {
    $new = $this->getNewValue();
    return PhabricatorAuditCommitStatusConstants::newForLegacyStatus($new);
  }

  public function getIcon() {
    return $this->getAuditStatusObject()->getIcon();
  }

  public function getColor() {
    return $this->getAuditStatusObject()->getColor();
  }

  public function getTitle() {
    $status = $this->getAuditStatusObject();

    switch ($status->getKey()) {
      case PhabricatorAuditCommitStatusConstants::MODERN_NONE:
        return pht('This commit no longer requires audit.');
      case PhabricatorAuditCommitStatusConstants::MODERN_NEEDS_AUDIT:
        return pht('This commit now requires audit.');
      case PhabricatorAuditCommitStatusConstants::MODERN_CONCERN_RAISED:
        return pht('This commit now has outstanding concerns.');
      case PhabricatorAuditCommitStatusConstants::MODERN_NEEDS_VERIFICATION:
        return pht('This commit now requires verification by auditors.');
      case PhabricatorAuditCommitStatusConstants::MODERN_AUDITED:
        return pht('All concerns with this commit have now been addressed.');
    }

    return null;
  }

  public function getTitleForFeed() {
    $status = $this->getAuditStatusObject();

    switch ($status->getKey()) {
      case PhabricatorAuditCommitStatusConstants::MODERN_NONE:
        return pht(
          '%s no longer requires audit.',
          $this->renderObject());
      case PhabricatorAuditCommitStatusConstants::MODERN_NEEDS_AUDIT:
        return pht(
          '%s now requires audit.',
          $this->renderObject());
      case PhabricatorAuditCommitStatusConstants::MODERN_CONCERN_RAISED:
        return pht(
          '%s now has outstanding concerns.',
          $this->renderObject());
      case PhabricatorAuditCommitStatusConstants::MODERN_NEEDS_VERIFICATION:
        return pht(
          '%s now requires verification by auditors.',
          $this->renderObject());
      case PhabricatorAuditCommitStatusConstants::MODERN_AUDITED:
        return pht(
          'All concerns with %s have now been addressed.',
          $this->renderObject());
    }

    return null;
  }

}
