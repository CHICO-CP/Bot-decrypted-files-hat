import base64
from Crypto.Cipher import AES
from Crypto.Util.Padding import unpad
import telebot
import os

# Solicitar el token del bot al usuario
TOKEN = input("Enter the bot token: ").strip()

# Verificar si el token es válido antes de continuar
if not TOKEN:
    print("Error: The token provided is invalid.")
    exit()

# Extensiones de archivo permitidas
ALLOWED_EXTENSIONS = {".hat"}

# Mensajes de inicio y fin
Px_inicio = "┌───────────────\n├ 𝗛𝗔𝗧 𝗧𝗨𝗡𝗡𝗘𝗟 𝗕𝗢𝗧 𝗗𝗘𝗖𝗥𝗬𝗣𝗧𝗢𝗥\n├ 𝗗𝗲𝘃𝗲𝗹𝗼𝗽𝗲𝗿: https://bit.ly/jhkhw\n├───────────────\n"

# Preguntar al usuario por el ID del bot
bot_id = input("Enter your bot's ID: ").strip()
if not bot_id:
    print("Error: You must enter the bot's ID.")
    exit()

# Preguntar al usuario por la activación de Bit
activated_bit = input("Enter the Activated by: ").strip()
if not activated_bit:
    print("Error: You must enter the Activated by.")
    exit()

# Preguntar al usuario por el link de su grupo (si es un grupo)
group_link = input("Enter your group link (if applicable): ").strip()

# Personalizar esta sección con los datos específicos del usuario
Px_fin = f"\n├───────────────\n│ 𝗕𝗼𝘁 𝗜𝗗: {bot_id}\n├ 𝗔𝗰𝘁𝗶𝘃𝗮𝘁𝗲𝗱 𝗯𝘆: {activated_bit}\n├ 𝗚𝗿𝗼𝘂𝗽 𝗟𝗶𝗻𝗸: {group_link}\n└───────────────"

# Preguntar al usuario por el ID del bot
bot_id = input("Enter your bot's ID: ").strip()
if not bot_id:
    print("Error: You must enter the bot's ID.")
    exit()

# Preguntar al usuario por la activación de Bit
activated_bit = input("Enter the ActivatedBit: ").strip()
if not activated_bit:
    print("Error: You must enter the ActivatedBit.")
    exit()

# Preguntar al usuario por su usuario de Telegram
user_telegram = input("Enter your Telegram username: ").strip()
if not user_telegram:
    print("Error: You must enter your Telegram username.")
    exit()

# Preguntar al usuario por el link de su grupo (si es un grupo)
group_link = input("Enter your group link (if applicable): ").strip()

# Personalizar esta sección con los datos específicos del usuario
Px_fin = f"\n├───────────────\n│ 𝗕𝗼𝘁 𝗜𝗗: {bot_id}\n├ 𝗔𝗰𝘁𝗶𝘃𝗮𝘁𝗲𝗱 𝗯𝘆: {activated_bit}\n├ 𝗖𝗼𝗱𝗲 𝗯𝘆: {user_telegram}\n├ 𝗚𝗿𝗼𝘂𝗽 𝗟𝗶𝗻𝗸: {group_link}\n└───────────────"

# Esta es la función de descifrado
def aes_ecb_decrypt(data, key):
    cipher = AES.new(key, AES.MODE_ECB)
    decrypted = cipher.decrypt(data)
    return unpad(decrypted, AES.block_size)

# Esto se definió para agregar un filtro en el texto decodificado
def adding_filter(text):
    text = text.replace(',', '\n')
    return text

# Validar la extensión del archivo
def allowed_file(filename):
    return os.path.splitext(filename)[1].lower() in ALLOWED_EXTENSIONS

# Manejar comando /start
@bot.message_handler(commands=['start'])
def handle_start(message):
    try:
        bot.send_message(message.chat.id, 'Hello! I`m your decryption bot. Send an encrypted file and I`ll use my magic to decode it. 😊')
    except Exception as e:
        # Manejar cualquier excepción y seguir activo
        print(f"Error en handle_start: {e}")

# Manejar mensajes con archivos
@bot.message_handler(content_types=['document'])
def handle_file(message):
    try:
        file_info = bot.get_file(message.document.file_id)
        file_extension = os.path.splitext(file_info.file_path)[1].lower()

        if file_extension not in ALLOWED_EXTENSIONS:
            return  # No envía ningún mensaje si la extensión no está permitida

        # Responder directamente al usuario que envió el archivo
        bot.reply_to(message, 'Decrypting the file... ⚙️')

        downloaded_file = bot.download_file(file_info.file_path)
        
        with open('encrypted_file.txt', 'wb') as new_file:
            new_file.write(downloaded_file)

        hat = base64.b64decode(open('encrypted_file.txt', 'rb').read())
        cle = base64.b64decode('zbNkuNCGSLivpEuep3BcNA==')

        # Definir cipher dentro de la función handle_file
        cipher = AES.new(cle, AES.MODE_ECB)

        decrypted_text = unpad(cipher.decrypt(hat), AES.block_size)
        final_text = decrypted_text.decode('utf-8')
        final_text = adding_filter(final_text)

        # Construir el mensaje
        full_message = Px_inicio

        # Agregar los resultados al mensaje con el prefijo │[❂]
        decoded_lines = [f'│[❂] {line}' for line in final_text.splitlines()]
        full_message += '' + '\n'.join(decoded_lines)

        # Agregar mensaje de finalización
        full_message += Px_fin

        # Enviar el mensaje completo, respondiendo al mensaje original del usuario
        bot.send_message(
            chat_id=message.chat.id,
            text=full_message,
            reply_to_message_id=message.message_id,
        )
    except Exception as e:
        # Manejar cualquier excepción y seguir activo
        print(f"Error: {e}")
        bot.reply_to(message, 'An error occurred during the process. Please try again later.')

# Imprimir mensaje indicando que el bot está activo
print("The bot is active and running.")

# Iniciar el bot
bot.polling()
