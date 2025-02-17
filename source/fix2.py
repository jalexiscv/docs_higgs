import os
import shutil


def adjust_underline_in_file(file_path):
    with open(file_path, 'r', encoding='utf-8') as file:
        lines = file.readlines()

    new_lines = []
    i = 0
    while i < len(lines):
        if i + 1 < len(lines):
            line1 = lines[i].rstrip('\n')
            line2 = lines[i + 1].rstrip('\n')

            if line1 and all(char == '-' for char in line2) and len(line2) < len(line1):
                line1_length = len(line1)
                new_line2 = '-' * line1_length
                new_lines.append(line1 + '\n')
                new_lines.append(new_line2 + '\n')
                i += 2
                continue

        new_lines.append(lines[i])
        i += 1

    with open(file_path, 'w', encoding='utf-8') as file:
        file.writelines(new_lines)


def process_rst_files(src_directory, dest_directory):
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
                adjust_underline_in_file(dest_file_path)


# Obtener el directorio actual
current_directory = os.getcwd()
# Definir el directorio de salida
output_directory = os.path.join(current_directory, 'output_rst_files')

# Procesar todos los archivos .rst en el directorio actual y escribir los resultados en el directorio de salida
process_rst_files(current_directory, output_directory)
