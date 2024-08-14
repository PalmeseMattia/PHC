#include <unistd.h>
#define STUFF 10

int main()
{
	write(1, "Hello\n", 6);
	return (0);
}
