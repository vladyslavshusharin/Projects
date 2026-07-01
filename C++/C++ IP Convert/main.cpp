#include <iostream>
#include <vector>
#include <limits>
#include <string>
#include <math.h>

using namespace std;

string buffer = "";
vector<string> BinIp;
vector<string> DecIp;
vector<string> MaskIp, MaskBin;
vector<string> NetIp, NetBin;
vector<string> BroadIp, BroadBin;
vector<string> FirstHost, LastHost;
vector<string> FirstBin, LastBin;

int mask;
string address;

vector<string> First(vector<string> NetIp){
  int hostnum = stoi(NetIp[3]);
  hostnum++;
  NetIp[3] = to_string(hostnum);
  return NetIp;
}

vector<string> Last(vector<string> BroadIp){
  int hostnum = stoi(BroadIp[3]);
  hostnum--;
  BroadIp[3] = to_string(hostnum);
  return BroadIp;
}

vector<string> Broadcast(vector<string> BinIp, int mask){
  
  string BroadIterate = "";


for(int i = 0; i < BinIp.size(); i++){
  BroadIterate += BinIp[i];
}

for(int i = 0; i < BroadIterate.length(); i++){

  if(i >= mask){
    BroadIterate[i] = '1';
  }

}

for(int i = 0; i < BinIp.size(); i++){
   BinIp[i] = "";
   
   for(int j = 0+(8*i); j < 8+(8*i); j++){
    
    BinIp[i] += BroadIterate[j];
   
   }
}

return BinIp;
}

vector<string> Network(vector<string> BinIp, int mask){

  string NetIterate = "";


for(int i = 0; i < BinIp.size(); i++){
  NetIterate += BinIp[i];
}

for(int i = 0; i < NetIterate.length(); i++){

  if(i >= mask){
    NetIterate[i] = '0';
  }

}

for(int i = 0; i < BinIp.size(); i++){
   BinIp[i] = "";
   
   for(int j = 0+(8*i); j < 8+(8*i); j++){
    
    BinIp[i] += NetIterate[j];
   
   }
}

return BinIp;
}

vector<string> Mask(vector<string> BinIp, int mask){

string MaskIterate = "";


for(int i = 0; i < BinIp.size(); i++){
  MaskIterate += BinIp[i];
}

for(int i = 0; i < MaskIterate.length(); i++){

  if(i < mask){
    MaskIterate[i] = '1';
  }
  if(i >= mask){
    MaskIterate[i] = '0';
  }

}

for(int i = 0; i < BinIp.size(); i++){
   BinIp[i] = "";
   
   for(int j = 0+(8*i); j < 8+(8*i); j++){
    
    BinIp[i] += MaskIterate[j];
   
   }
}
return BinIp;
}


vector<string> ConvertToBin(vector<string> DecIp){

for(int l = 0; l < DecIp.size(); l++){
int num;

num = stoi(DecIp[l]);
DecIp[l] = "";
for(int i = 0; num > 0; i++){
  
  DecIp[l].insert(DecIp[l].begin(), '0' + (num%2));
  num = num/2;
  
   }
 }

 for(int i = 0; i < DecIp.size(); i++){
   
   if(DecIp[i].length() < 8){
    for(int j = DecIp[i].length(); j < 8; j++){
      DecIp[i].insert(DecIp[i].begin(), '0');
    }
  }


 }
return DecIp;
}

vector<string> ConvertToDec(vector<string> Bin){


int DecNum = 0;;

for(int i = 0; i < Bin.size(); i++){

 for(int j = 0; j < Bin[i].length(); j++){

  if(Bin[i][(Bin[i].length()-1)-j] == '1'){
    
    DecNum += pow(2,j);
  
  }
  
    }
  Bin[i] = to_string(DecNum);
  DecNum = 0;
  }

  return Bin;
}

void SpaceMaker(vector<string> DesiredVector){

int standardLength = 12;
for(int i = 0; i < DesiredVector.size(); i++){

  for(int j = 0; j < DesiredVector[i].length(); j++){
    standardLength--;
  }
  
}

for(int i = 0; i < standardLength; i++){
  cout << " ";
}

}



int main(){


while(true){
 int k = 0;
 
 cout << "Type in an adress: ";
 getline(cin, address);

 for(int i = 0; i < address.length(); i++){
    
    if(address[i] == '.'){
        k++;
    }
    
   }
 
 if(k == 3){

    for(int i = 0; i < address.length(); i++){
        if(address[i] == '.'){
          DecIp.push_back(buffer);
          buffer = "";
        }
        else{
          buffer += address[i];
        }
        if(i == address.length()-1){
          DecIp.push_back(buffer);
          buffer = "";
        }
        
    }

    break;
    }
 
 else{
     cout << "Address must have 4 octets" << endl;;
     continue;
     }

}

while(true){
 cout << "Type in a mask: ";
 cin >> mask;

 if(mask <= 32 && mask > 0){
    
    break;
}

 else if(mask > 32 || mask <= 0){
    cout << endl << "Mask cannot be 0 or above 32...";
    }

}


cout << endl;
cout << "Mask: " << mask << endl;
cout << "IP Address:        ";
for(int i = 0; i < DecIp.size(); i++){
    if(i < DecIp.size()-1){
        cout << DecIp[i] << ".";
    }
    else{
        cout << DecIp[i];
    }
}
SpaceMaker(DecIp);

cout << "   ";

BinIp = ConvertToBin(DecIp);

for(int i = 0; i < BinIp.size(); i++){
    cout << BinIp[i] << " ";
}

cout << endl << endl;

MaskBin = Mask(BinIp, mask);
MaskIp = ConvertToDec(MaskBin);

cout << "Mask Address:      ";

for(int i = 0; i < MaskIp.size(); i++){
    if(i < MaskIp.size()-1){
        cout << MaskIp[i] << ".";
    }
    else{
        cout << MaskIp[i];
    }
}
SpaceMaker(MaskIp);

cout << "   ";

for(int i = 0; i < MaskBin.size(); i++){
    cout << MaskBin[i] << " ";
}

cout << endl << endl;

NetBin = Network(BinIp, mask);
NetIp = ConvertToDec(NetBin);

cout << "Network Address:   ";

for(int i = 0; i < NetIp.size(); i++){
    if(i < NetIp.size()-1){
        cout << NetIp[i] << ".";
    }
    else{
        cout << NetIp[i];
    }
}
SpaceMaker(NetIp);

cout << "   ";

for(int i = 0; i < NetBin.size(); i++){
    cout << NetBin[i] << " ";
}

cout << endl;

BroadBin = Broadcast(BinIp, mask);
BroadIp = ConvertToDec(BroadBin);

cout << "Broadcast Address: ";

for(int i = 0; i < BroadIp.size(); i++){
    if(i < BroadIp.size()-1){
        cout << BroadIp[i] << ".";
    }
    else{
        cout << BroadIp[i];
    }
}
SpaceMaker(BroadIp);

cout << "   ";

for(int i = 0; i < BroadBin.size(); i++){
    cout << BroadBin[i] << " ";
}

cout << endl << endl;

FirstHost = First(NetIp);
LastHost = Last(BroadIp);
FirstBin = ConvertToBin(FirstHost);
LastBin = ConvertToBin(LastHost);

cout << "First Host:        ";
for(int i = 0; i < FirstHost.size(); i++){
    if(i < FirstHost.size()-1){
        cout << FirstHost[i] << ".";
    }
    else{
        cout << FirstHost[i];
    }
}
SpaceMaker(FirstHost);

cout << "   ";

for(int i = 0; i < FirstBin.size(); i++){
    cout << FirstBin[i] << " ";
}

cout << endl << "Last Host:         ";

for(int i = 0; i < LastHost.size(); i++){
    if(i < LastHost.size()-1){
        cout << LastHost[i] << ".";
    }
    else{
        cout << LastHost[i];
    }
}
SpaceMaker(LastHost);

cout << "   ";

for(int i = 0; i < LastBin.size(); i++){
    cout << LastBin[i] << " ";
}

return 0;


}
