<?php
declare(strict_types=1);

namespace NinjaKnights\CosmeticMenu\Particles;

use pocketmine\math\Vector3;
use pocketmine\level\particle\GenericParticle;
use pocketmine\level\particle\Particle;

class Conduit extends GenericParticle {
	public function __construct(Vector3 $pos) {
		parent::__construct($pos, Particle::TYPE_CONDUIT);
	}
}