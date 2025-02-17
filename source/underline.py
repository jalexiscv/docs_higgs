import os
import re


def correct_title_underline(lines):
    corrected_lines = []
    i = 0
    while i < len(lines):
        line = lines[i]
        corrected_lines.append(line)

        if i < len(lines) - 1:
            next_line = lines[i + 1]
            # Check if the next line is a title underline
            if re.match(r'^[=~`^"+#<>*]+$', next_line.strip()):
                title_length = len(line.rstrip())
                underline_char = next_line.strip()[0]
                if len(next_line.strip()) != title_length:
                    corrected_lines.append(underline_char * title_length + '\n')
                else:
                    corrected_lines.append(next_line)
                i += 1

        # Check for title overline
        if i > 0 and re.match(r'^[=~`^"+#<>*]+$', line.strip()):
            prev_line = lines[i - 1]
            if len(line.strip()) != len(prev_line.strip()):
                corrected_lines[-1] = line.strip()[0] * len(prev_line.strip()) + '\n'

        i += 1
    return corrected_lines


def correct_list_endings(lines):
    corrected_lines = []
    i = 0
    while i < len(lines):
        line = lines[i]
        corrected_lines.append(line)

        # Check for bullet or definition list ending
        if line.strip().endswith(':'):
            if i < len(lines) - 1 and lines[i + 1].strip():
                corrected_lines.append('\n')

        i += 1
    return corrected_lines


def correct_rst_file(input_path, output_path):
    try:
        with open(input_path, 'r', encoding='utf-8') as file:
            lines = file.readlines()

        corrected_lines = correct_title_underline(lines)
        corrected_lines = correct_list_endings(corrected_lines)

        output_dir = os.path.dirname(output_path)
        if not os.path.exists(output_dir):
            os.makedirs(output_dir)

        with open(output_path, 'w', encoding='utf-8') as file:
            file.writelines(corrected_lines)
    except Exception as e:
        print(f"Error correcting {input_path}: {e}")


def correct_all_rst_files(input_dir, output_dir):
    if not os.path.exists(output_dir):
        os.makedirs(output_dir)
    for root, dirs, files in os.walk(input_dir):
        for file in files:
            if file.endswith('.rst'):
                input_path = os.path.join(root, file)
                relative_path = os.path.relpath(input_path, input_dir)
                output_path = os.path.join(output_dir, relative_path)
                print(f'Correcting {input_path} to {output_path}')
                correct_rst_file(input_path, output_path)


# Configura los directorios de entrada y salida
input_directory = r'C:\xampp\Code-Higgs-Framework\source'
output_directory = r'C:\xampp\Code-Higgs-Framework\corrected'

# Ejecuta la función de corrección
correct_all_rst_files(input_directory, output_directory)
