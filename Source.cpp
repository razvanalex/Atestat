#include<iostream>
#include<fstream>

using namespace std;

void initializare(int n, int (&a)[100][100])
{
	for (int i = 1; i <= n; i++)
		for (int j = 1; j <= n; j++)
			a[i][j] = 0;
}

void citire(int &n, int &m, int (&a)[100][100])
{
	cout << "Introduceti nr de noduri: "; cin >> n;
	cout << "Introduceti nr de muchii: "; cin >> m;
	initializare(n, a);
	
	int x1, x2;
	bool valid;

	for (int i = 1; i <= m; i++)
	{
		do { 
			cout << "Introduceti muchia " << i << ": "; cin >> x1 >> x2;
			valid = false;
			if ((x1 > 0 && x1 <= n) || (x2 > 0 && x2 <= n))
				valid = true;
		} while (!valid);

		a[x1][x2] = 1;
		a[x2][x1] = 1;
	}
}

void citire(int &n, int &m, int (&a)[100][100], ifstream &f)
{
	f >> n >> m;
	initializare(n, a);

	int x1, x2;
	bool valid;

	for (int i = 1; i <= m; i++)
	{
		do {
			f >> x1 >> x2;
			valid = false;
			if ((x1 > 0 && x1 <= n) || (x2 > 0 && x2 <= n))
				valid = true;
		} while (!valid);

		a[x1][x2] = 1;
		a[x2][x1] = 1;
	}
}

void afisareMatrice(int n, int a[100][100])
{
	cout << endl;
	for (int i = 1; i <= n; i++)
	{
		for (int j = 1; j <= n; j++)
			cout << a[i][j] << " ";
		cout << endl;
	}
}

int grad(int nod, int n, int a[100][100])
{
	int grad = 0;

	for (int i = 1; i <= n; i++)
		if (a[nod][i] == 1)
			grad++;

	return grad;
}

int NrNoduriIzolate(int n, int a[100][100])
{
	int NodIz = 0;
	for (int i = 1; i <= n; i++)
		if (grad(i, n, a) == 0)
			NodIz++;
	return NodIz;
}

void afisareNoduriIzolate(int n, int a[100][100])
{
	if (NrNoduriIzolate(n, a) == 0)
		cout << "Nu exista noduri izolate.";
	else if (NrNoduriIzolate(n, a) == 1)
		cout << "Este un singur nod izolat: ";
	else cout << "Cele " << NrNoduriIzolate(n, a) << " noduri izolate sunt: ";
	for (int i = 1; i <= n; i++)
		if (grad(i, n, a) == 0)
			cout << i << " ";
	cout << endl; 
}

int main()
{
	int n, m, a[100][100];
	ifstream f("nod.in");
	
	citire(n, m, a, f);
	afisareMatrice(n, a);
	
	afisareNoduriIzolate(n, a);

	system("Pause");
	return 0;
}