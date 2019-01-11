<?php

/* php student exercices 
    php little app that simulate Robert's actions when ordering and drinking beers


possible implementations are
 timetogohome varie en fonction du jour de la semaine, de l'humeur 
 temps pour boire une biere varie en fontion du degrée d'alcolemie
 choix de la bière avec des effets différents
/perception du temps qui varie en fonction du degrée d'alcoolémie
 Robert a un fonction qui lui permet de commander des bieres à josianne la serveuse qui n'est pas toujours disponible (temps/capital symptahie)
 Robert au bout d'un moment ne commande plus mais tente plutot de séduire la serveuse, au bout de quelques bieres il n'arrive a plus rien du tout
Créer une classe parent ou une interface Humain et Boisson avec des fonctions génériques
 Créer un input utilisateur pour pouvoir choisir les actions et les paramètres
 Assurer la persistence des données en base de données pour une continuité et un historique
/Modifier le rendu des différents retour d'actions
faire un ptit onglet qui affiche le statut des fonctions vitales de robert et josianne a chaque chargement de page


// déporter tout ce qui est rendu à la classe Renderer 
// Conditionner non pas au nbre de biere mais au degré d'alcoolemie ( <2grammes)
// Séparer la commande qui permet à partir d un formulaire de sélectionner la bière choisie 
//( legere et forte) et le nmbre 

*/

print "<h2>time to go home </h2>";





Class DateGetter{
	
	function getCurrentSecond(){
		return date('s');
	}
	
	function getTimeLimitByDay(){	
	

		$heureLimite= 24;
		$current_Day=date("N");	
		if ($current_Day>5){
			$heureLimite=23;
		}	
		return $heureLimite;
	}	
}

Class Robert{
	var $DrunkBeers=0;
	var $DegreeAlcoolemie=0;
	
	function GetNumberOfBeers(){
		return $this->DrunkBeers;		
	}	
	
	function GetAlcool(){
		return $this->DegreeAlcoolemie;		
	}
	
	function BoireuneBiere($heure, $beerNumber){	
		
		$dateG=new DateGetter;
		$current_time=$dateG->getCurrentSecond();
		echo 'il est '. $current_time . ' heure,';
		$message="<p>refus</p>";
		
		if( $current_time < $heure )	{					
			while ($beerNumber>0){
				$beerNumber--;
				$taux_alcool=$this->GetAlcool();
				if($taux_alcool<2){		
				echo '<p>taux: '.$taux_alcool. '<br>';					
				echo $beerNumber;						
				$this->DrunkBeers = $this->DrunkBeers +1;
				$this->DegreeAlcoolemie = $this->GetAlcool()+ 0.5;						
				}
			}		
		}		
		return $message;
	}
	
	function OrderBeer () {	
		$htmls= new Renderer;
		$htmls->afficherFormulaire();
		$NombreDeBieresChoisies=isset($_POST ["nombre"])?$_POST ["nombre"]:0;
		return $NombreDeBieresChoisies;
	}
}

Class Renderer{	
	function RenderBeers($nbreBiere){
		$html='<h3>niet</h3>';		
		while ($nbreBiere>0){
			print "<img src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRu-NvcBZb8jpEfiVL5B4oJrEtdNZAmi5SnCaGqFkVU8QHLmq8vdA'></img>";
			$nbreBiere--;
		}		
	}

	function afficherFormulaire(){
		print "<h2>Commander une biere </h2><form method='POST'>
<label for='nombre'>Nombre:</label>
<input type='text' id='nombre' name='nombre' required>
<label for='bier_type'>choix de la bière:</label>
  <select name='bier_type' required>
    <option value='blonde'>blonde</option>
    <option value='brune'>brune</option>   
  </select>
  <input type='submit' value='Submit'>
</form>";	
	
	}	
	
	
}
$Robert_007=new Robert;
$dateG=new DateGetter;

$timeToGoHome = $dateG->getTimeLimitByDay();
$number=$Robert_007->OrderBeer();
$result=$Robert_007->BoireuneBiere($timeToGoHome,$number);
$nbBiereBu=$Robert_007->DrunkBeers;



$htmls= new Renderer;
//$htmls->afficherFormulaire();
$BeerRender=$htmls->RenderBeers($nbBiereBu);
print $BeerRender;














?>