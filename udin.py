import numpy as np

import matplotlib.pyplot as plt

def plot_linear_equation(m, b):
    x = np.linspace(-10, 10, 100)  # Generate x values from -10 to 10
    y = m * x + b  # Calculate y values using the linear equation y = mx + b

    plt.plot(x, y)  # Plot the graph
    plt.xlabel('x')
    plt.ylabel('y')
    plt.title('Graph of Linear Equation: y = {}x + {}'.format(m, b))
    plt.grid(True)
    plt.show()

# Example usage
m = 2  # Slope of the line
b = 3  # y-intercept
plot_linear_equation(m, b)