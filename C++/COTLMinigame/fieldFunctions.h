#include <iostream>
#include <vector>
#include "playerFunctions.h"
#include "enemyFunctions.h"

using namespace std;

void FieldOutput(vector<vector<int>> PlayerPlacements, vector<vector<int>> EnemyPlacements){


cout << " [ " << PlayerPlacements[0][0] << " ] " << " [ " << PlayerPlacements[1][0] << " ] " << " [ " << PlayerPlacements[2][0] << " ] " << endl;
cout << " [ " << PlayerPlacements[0][1] << " ] " << " [ " << PlayerPlacements[1][1] << " ] " << " [ " << PlayerPlacements[2][1] << " ] " << endl;
cout << " [ " << PlayerPlacements[0][2] << " ] " << " [ " << PlayerPlacements[1][2] << " ] " << " [ " << PlayerPlacements[2][2] << " ] " << endl;
cout << "--------------------------------------------" << endl;
cout << " [ " << EnemyPlacements[0][0] << " ] " << " [ " << EnemyPlacements[1][0] << " ] " << " [ " << EnemyPlacements[2][0] << " ] " << endl;
cout << " [ " << EnemyPlacements[0][1] << " ] " << " [ " << EnemyPlacements[1][1] << " ] " << " [ " << EnemyPlacements[2][1] << " ] " << endl;
cout << " [ " << EnemyPlacements[0][2] << " ] " << " [ " << EnemyPlacements[1][2] << " ] " << " [ " << EnemyPlacements[2][2] << " ] " << endl;

}

void FieldCompare(vector<vector<int>> PlayerPlacements, vector<vector<int>> EnemyPlacements){

}
