import os
from google.cloud import translate_v2 as translate
import re


def translate_text(text, target_lang='es'):
    client = translate.Client()
    translation = client.translate(text, target_language=target_lang)
    return translation['translatedText']


def is_translatable_line(line):
    # Define qué líneas deben ser traducidas: líneas que no comienzan con '..' y no son vacías
    return bool(line.strip()) and not line.strip().startswith('..')


def translate_rst_file(input_path, output_path, target_lang='es'):
    try:
        with open(input_path, 'r', encoding='utf-8') as file:
            lines = file.readlines()

        translated_lines = []
        for line in lines:
            if is_translatable_line(line):
                translated_line = translate_text(line.strip(), target_lang)
                # Agrega la línea traducida con el mismo número de espacios iniciales para mantener el formato
                translated_lines.append(re.match(r"\s*", line).group() + translated_line + '\n')
            else:
                translated_lines.append(line)

        with open(output_path, 'w', encoding='utf-8') as file:
            file.writelines(translated_lines)
    except Exception as e:
        print(f"Error translating {input_path}: {e}")


def translate_all_rst_files(input_dir, output_dir, target_lang='es'):
    if not os.path.exists(output_dir):
        os.makedirs(output_dir)
    for root, dirs, files in os.walk(input_dir):
        for file in files:
            if file.endswith('.rst'):
                input_path = os.path.join(root, file)
                relative_path = os.path.relpath(input_path, input_dir)
                output_path = os.path.join(output_dir, relative_path)
                output_dir_path = os.path.dirname(output_path)
                if not os.path.exists(output_dir_path):
                    os.makedirs(output_dir_path)
                print(f'Translating {input_path} to {output_path}')
                translate_rst_file(input_path, output_path, target_lang)


# Configura los directorios de entrada y salida
input_directory = r'C:\xampp\Code-Higgs-Framework\source'
output_directory = r'C:\xampp\Code-Higgs-Framework\translated'

# Ejecuta la función de traducción
translate_all_rst_files(input_directory, output_directory)
