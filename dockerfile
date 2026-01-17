# Use the official PHP image
FROM php:8.2-cli

# Set the working directory
WORKDIR /usr/src/app

# Copy the PHP file into the container
COPY simpledashboard.php .

# Command to run the PHP server on port 8000
CMD ["php", "-S", "0.0.0.0:80", "simpledashboard.php"]
