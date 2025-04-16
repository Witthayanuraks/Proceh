# pip install pillow pygame 

import tkinter as tk
from PIL import Image, ImageTk
import pygame

# -------------------- SETUP MUSIK -------------------- #
try:
    pygame.mixer.init()
    pygame.mixer.music.load("./Gapakelama.mp3") 
    pygame.mixer.music.play(-1)  
except Exception as e:
    print("MANA MUSIKNA NJIR ", e)

# -------------------- SETUP WINDOW -------------------- #
root = tk.Tk()
root.title("Media Player")
bg_image = Image.open("./Area_Penacony_Grand_Theater.webp")
bg_photo = ImageTk.PhotoImage(bg_image)
bg_label = tk.Label(root, image=bg_photo)
bg_label.place(x=0, y=0, relwidth=1, relheight=1)

# Atur ukuran window mengikuti ukuran background image
root.geometry(f"{bg_image.width}x{bg_image.height}")

# -------------------- LOAD GAMBAR UNTUK LIRIK -------------------- #
img1 = Image.open("./RobinDJ.webp")
img1 = img1.resize((200, 150), resample=Image.Resampling.LANCZOS)
img1_photo = ImageTk.PhotoImage(img1)
img2 = Image.open("./Sticker_PPG_14_Robin_01.webp")
img2 = img2.resize((200, 150), resample=Image.Resampling.LANCZOS)
img2_photo = ImageTk.PhotoImage(img2)

# Simpan referensi agar gambar tidak dihapus oleh garbage collector
root.img1_photo = img1_photo
root.img2_photo = img2_photo

# -------------------- SETUP WIDGET -------------------- #
title_label = tk.Label(root, text="Robin - Gak Pake Lama", font=("Helvetica", 16, "bold"),
                       bg="#ffffff", fg="#333333")
title_label.place(x=20, y=20)
start_button = tk.Button(root, text="Mulai", command=lambda: start_animation())
start_button.place(x=300, y=20)
exit_button = tk.Button(root, text="Keluar", command=lambda: close_app())
exit_button.place(x=370, y=20)
text_widget = tk.Text(root, font=("Helvetica", 14), width=50, height=15,
                      bg="#ffffff", fg="#000000", bd=5)
text_widget.place(x=20, y=60)

images_insertion = {3: img1_photo, 7: img2_photo}

# -------------------- ANIMASI TEKS -------------------- #
def animate_text():
    # List lirik beserta delay per karakter (dalam detik)
    lines = [
        ("..................", 0.10),
        ("Setiap kali kita bertemu", 0.10),
        ("Aku lihat kamu senyum padaku", 0.10),
        ("Ku tahu kamu suka padaku", 0.10),
        ("Tapi kamu ragu bilang begitu", 0.10),
        ("Terlalu lama kamu membuang waktumu", 0.19),
        ("Terlalu lama memendam rasa", 0.22),
        ("Gak pake lama", 0.15),
        ("Bilang saja kalau kau suka", 0.16),
        ("Gak pake lama", 0.15),
        ("Bilang saja kalau kau cinta", 0.16),
        ("Dan aku juga suka", 0.17),
        ("Suka kamu", 0.14),
        ("Ku tunggu sampai kamu bilang I love you", 0.17),
        ("❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤❤", 0.15)
    ]

    colors = ["red", "green", "blue", "purple", "orange", "cyan"]
    
    def animate_next_char(line_index, char_index):
        if line_index < len(lines):
            line, delay = lines[line_index]
            color = colors[line_index % len(colors)]
            if char_index < len(line):
                text_widget.insert(tk.END, line[char_index], color)
                text_widget.see(tk.END)
                # Jadwalkan karakter selanjutnya (delay dalam milidetik)
                text_widget.after(int(delay * 1000), animate_next_char, line_index, char_index + 1)
            else:
                text_widget.insert(tk.END, "\n")
                # Sisipkan gambar jika indeks baris sesuai
                if line_index in images_insertion:
                    text_widget.image_create(tk.END, image=images_insertion[line_index])
                    text_widget.insert(tk.END, "\n")
                # Lanjut ke baris berikutnya
                text_widget.after(100, animate_next_char, line_index + 1, 0)
        else:
            start_button.config(state=tk.NORMAL)
    
    animate_next_char(0, 0)

def start_animation():
    start_button.config(state=tk.DISABLED)
    text_widget.delete("1.0", tk.END)
    animate_text()

def close_app():
    try:
        pygame.mixer.music.stop()
    except Exception:
        pass
    root.destroy()

root.mainloop()
