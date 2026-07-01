#include <iostream>
#include "fieldFunctions.h"

using namespace std;


int main(){

Player* player = new Player;
Enemy* enemy = new Enemy;

while (true){

string nothing;

FieldOutput(player->PlayerPlacements, enemy->EnemyPlacements);

cin.clear();

cin >> nothing;

system("cls");


 }
}