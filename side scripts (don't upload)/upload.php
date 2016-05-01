<?php
/**
 * Created by PhpStorm.
 * User: Hunter
 * Date: 2/22/2016
 * Time: 1:30 AM
 */

$appStr = "McDonald's
Subway
Starbucks
Burger King
Wendy's
Taco Bell
Dunkin Donuts
Pizza Hut
KFC
Applebee's
Chick-fil-a
Sonic
Olive Garden
Chili's
Domino's
Panera
Jack in the Box
Arby's
Dairy Queen
Red Lobster
IHOP
Denny's
Outback
Chipotle
Papa John's
Buffalo Wild Wing's
Cracker Barrell
Hardee's
T.G.I. Friday's
7-Eleven
Popeyes
Golden Corral
Cheesecake Factory
Panda Express
Little Caesars
Carl's Jr.
Ruby  Tuesday
Texas Roadhouse
Whataburger
Red Robin
Quiznos
Zaxby's
Steak n Shake
Bojangles
Culver's
Long John Silver's
Perkins restaurant
Carrabba's
California Pizza Kitchen
Logan's Roadhouse
Romano Macaroni Grill
BJ's Restaurant and Brewery
In-N-Out Burger
Del Taco
Circle K
Friendly's
El Pollo Loco
Jason's Deli
O'Charley's
Boston Market
Krispy Kreme
Wawa
Qdoba
White Castle
Casey's General Store
Baskin-Robbins
Famous Dave's
Tim Horton's
Ruth's Chris Steak House
Bonefish Grill
Sheetz
Jamba Juice
Cheddar's
Einstein Bros. Bagels
Captain D's Seafood
Sbarro
Krystal
Big Boy Restaurant and Bakery
On the Border Mexican Grill and Cantina
California Tortilla
Capitol Grille
Checker's
Cracker Barrell";

$apps = explode("\n", $appStr);

require_once "../db/conn.php";

$query = "insert into answer_options value(null, 8, ?, ?, now(), now())";

foreach($apps as $index => $app){
    $stmt = $conn->prepare($query);
    $i = $index+1;
    $stmt->bind_param("is", $i, $app);
    $stmt->execute();
}