<?php

/**
 * Created by PhpStorm.
 * User: cmoulia
 * Date: 28/02/2017
 * Time: 11:32
 */

namespace Entity;

use OCFram\Entity;

/**
 * Class News
 *
 * @package Entity
 */
class News extends Entity {
	const AUTEUR_INVALIDE  = 1;
	const TITRE_INVALIDE   = 2;
	const CONTENU_INVALIDE = 3;
	/**
	 * @var string
	 */
	protected $auteur;
	/**
	 * @var string
	 */
	protected $titre;
	/**
	 * @var string
	 */
	protected $contenu;
	/**
	 * @var \DateTime
	 */
	protected $dateAjout;
	/**
	 * @var \DateTime
	 */
	protected $dateModif;
	
	/**
	 * @return bool
	 */
	public function isValid() {
		return !( empty( $this->auteur ) || empty( $this->titre ) || empty( $this->contenu ) );
	}
	
	/**
	 * @return string
	 */
	public function getAuteur() {
		return $this->auteur;
	}
	
	/**
	 * @param string $auteur
	 */
	public function setAuteur( $auteur ) {
		if ( !is_string( $auteur ) || empty( $auteur ) ) {
			$this->erreurs[] = self::AUTEUR_INVALIDE;
		}
		
		$this->auteur = $auteur;
	}
	
	/**
	 * @return string
	 */
	public function getTitre() {
		return $this->titre;
	}
	
	/**
	 * @param string $titre
	 */
	public function setTitre( $titre ) {
		if ( !is_string( $titre ) || empty( $titre ) ) {
			$this->erreurs[] = self::TITRE_INVALIDE;
		}
		
		$this->titre = $titre;
	}
	
	/**
	 * @return string
	 */
	public function getContenu() {
		return $this->contenu;
	}
	
	/**
	 * @param string $contenu
	 */
	public function setContenu( $contenu ) {
		if ( !is_string( $contenu ) || empty( $contenu ) ) {
			$this->erreurs[] = self::CONTENU_INVALIDE;
		}
		
		$this->contenu = $contenu;
	}
	
	/**
	 * @return \DateTime
	 */
	public function getDateAjout() {
		return $this->dateAjout;
	}
	
	/**
	 * @param \DateTime $dateAjout
	 */
	public function setDateAjout( $dateAjout ) {
		$this->dateAjout = $dateAjout;
	}
	
	/**
	 * @return \DateTime
	 */
	public function getDateModif() {
		return $this->dateModif;
	}
	
	/**
	 * @param \DateTime $dateModif
	 */
	public function setDateModif( $dateModif ) {
		$this->dateModif = $dateModif;
	}
}