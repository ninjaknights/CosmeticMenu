<?php
declare(strict_types=1);

namespace NinjaKnights\CosmeticMenuV2\particleeffects;

use pocketmine\math\Vector3;
use pocketmine\level\particle\GenericParticle;
use pocketmine\level\particle\Particle;

class WitchCurseEffect extends GenericParticle {
	public function __construct(Vector3 $pos) {
		parent::__construct($pos, Particle::TYPE_WITCH_SPELL);
	}
}