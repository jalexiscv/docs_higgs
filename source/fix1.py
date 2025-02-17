import os
import shutil


def adjust_hashes_in_file(file_path):
    with open(file_path, 'r', encoding='utf-8') as file:
        lines = file.readlines()

    new_lines = []
    i = 0
    while i < len(lines):
        if i + 2 < len(lines):
            line1 = lines[i].strip()
            line2 = lines[i + 1].strip()
            line3 = lines[i + 2].strip()

            if line1.startswith('#') and line3.startswith('#') and not line2.startswith('#'):
                # Check if the lines are made up of '#' and text
                if all(char == '#' for char in line1) and all(char == '#' for char in line3):
                    line2_length = len(line2)
                    new_line1 = '#' * line2_length + '\n'
                    new_line3 = '#' * line2_length + '\n'
                    new_lines.append(new_line1)
                    new_lines.append(line2 + '\n')
                    new_lines.append(new_line3)
                    i += 3
                    continue

        new_lines.append(lines[i])
        i += 1

    with open(file_path, 'w', encoding='utf-8') as file:
        file.writelines(new_lines)


def copy_rst_files(src_directory, dest_directory):
    if not os.path.exists(dest_directory):
        os.makedirs(dest_directory)

    for root, _, files in os.walk(src_directory):
        for file in files:
            if file.endswith('.rst'):
                src_file_path = os.path.join(root, file)
                relative_path = os.path.relpath(src_file_path, src_directory)
                dest_file_path = os.path.join(dest_directory, relative_path)

                dest_file_dir = os.path.dirname(dest_file_path)
                if not os.path.exists(dest_file_dir):
                    os.makedirs(dest_file_dir)

                shutil.copy2(src_file_path, dest_file_path)


def process_rst_files(directory):
    for root, _, files in os.walk(directory):
        for file in files:
            if file.endswith('.rst'):
                file_path = os.path.join(root, file)
                adjust_hashes_in_file(file_path)


# Obtener el directorio actual
current_directory = os.getcwd()
output_directory = os.path.join(current_directory, 'output_rst_files')

# Copiar archivos .rst al directorio de salida
copy_rst_files(current_directory, output_directory)

# Procesar todos los archivos .rst en el directorio de salida
process_rst_files(output_directory)