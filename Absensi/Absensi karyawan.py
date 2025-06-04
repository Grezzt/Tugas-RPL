import tkinter as tk
from tkinter import messagebox
import mysql.connector
from datetime import datetime

# Koneksi database
conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="db_perusahaan"
)
cursor = conn.cursor(dictionary=True)

# ======== FUNGSI ========

def tampilkan_form_absen():
    frame_absen.pack(fill="both", expand=True)
    frame_info.pack_forget()
    entry_id.delete(0, tk.END)

def tampilkan_info(karyawan):
    frame_absen.pack_forget()
    frame_info.pack(fill="both", expand=True)
    entry_id.delete(0, tk.END)

    bulan_ini = datetime.now().strftime('%Y-%m')
    cursor.execute("""
        SELECT COUNT(*) AS jumlah FROM Absensi
        WHERE id_karyawan = %s AND DATE_FORMAT(tanggal, '%%Y-%%m') = %s
    """, (karyawan['id_karyawan'], bulan_ini))
    jumlah_hari = cursor.fetchone()['jumlah']
    total_gaji = (karyawan['gaji_pokok'] + karyawan['tunjangan']) * jumlah_hari

    cursor.execute("""
        SELECT tanggal, jam_masuk, jam_keluar FROM Absensi
        WHERE id_karyawan = %s ORDER BY tanggal DESC LIMIT 10
    """, (karyawan['id_karyawan'],))
    riwayat = cursor.fetchall()

    text_info.config(state="normal")
    text_info.delete("1.0", tk.END)
    text_info.insert(tk.END, f"📄 PROFIL KARYAWAN\n")
    text_info.insert(tk.END, f"ID       : {karyawan['id_karyawan']}\n")
    text_info.insert(tk.END, f"Nama     : {karyawan['nama']}\n")
    text_info.insert(tk.END, f"Jabatan  : {karyawan['nama_jabatan']}\n")
    text_info.insert(tk.END, f"Gaji Pokok: Rp {(karyawan['gaji_pokok'] + karyawan['tunjangan']):,.2f}\n")
    text_info.insert(tk.END, f"Gaji Bulan Ini: Rp {total_gaji:,.2f}\n\n")
    text_info.insert(tk.END, "🕒 Riwayat Absensi:\n")
    for a in riwayat:
        jam_keluar = a['jam_keluar'] if a['jam_keluar'] else "Belum Clock Out"
        text_info.insert(tk.END, f"- {a['tanggal']} | Masuk: {a['jam_masuk']} | Keluar: {jam_keluar}\n")
    text_info.config(state="disabled")

def clock_in():
    id_karyawan = entry_id.get().strip()
    if not id_karyawan:
        messagebox.showwarning("Input Kosong", "Silakan masukkan ID Karyawan!")
        return

    cursor.execute("""
        SELECT * FROM Karyawan k JOIN Jabatan j ON k.id_jabatan = j.id_jabatan
        WHERE id_karyawan = %s
    """, (id_karyawan,))
    karyawan = cursor.fetchone()

    if not karyawan:
        messagebox.showerror("Tidak Ditemukan", "ID Karyawan tidak valid.")
        return

    tanggal = datetime.now().strftime('%Y-%m-%d')
    jam_masuk = datetime.now().strftime('%H:%M:%S')

    cursor.execute("""
        SELECT * FROM Absensi
        WHERE id_karyawan = %s AND tanggal = %s
    """, (id_karyawan, tanggal))
    sudah_absen = cursor.fetchone()

    if sudah_absen:
        messagebox.showerror("Sudah Clock In", "Karyawan ini sudah melakukan clock in hari ini.")
        return

    cursor.execute("""
        INSERT INTO Absensi (id_karyawan, tanggal, jam_masuk, jam_keluar)
        VALUES (%s, %s, %s, NULL)
    """, (id_karyawan, tanggal, jam_masuk))
    conn.commit()

    messagebox.showinfo("Berhasil", f"Clock In berhasil pada {jam_masuk}")
    tampilkan_info(karyawan)

def clock_out():
    id_karyawan = entry_id.get().strip()
    if not id_karyawan:
        messagebox.showwarning("Input Kosong", "Silakan masukkan ID Karyawan!")
        return

    cursor.execute("""
        SELECT * FROM Karyawan k JOIN Jabatan j ON k.id_jabatan = j.id_jabatan
        WHERE id_karyawan = %s
    """, (id_karyawan,))
    karyawan = cursor.fetchone()

    if not karyawan:
        messagebox.showerror("Tidak Ditemukan", "ID Karyawan tidak valid.")
        return

    tanggal = datetime.now().strftime('%Y-%m-%d')
    jam_keluar = datetime.now().strftime('%H:%M:%S')

    cursor.execute("""
        SELECT * FROM Absensi
        WHERE id_karyawan = %s AND tanggal = %s AND jam_keluar IS NULL
    """, (id_karyawan, tanggal))
    absen_hari_ini = cursor.fetchone()

    if not absen_hari_ini:
        messagebox.showerror("Belum Clock In", "Karyawan ini belum melakukan clock in hari ini atau sudah clock out.")
        return

    cursor.execute("""
        UPDATE Absensi SET jam_keluar = %s
        WHERE id_karyawan = %s AND tanggal = %s AND jam_keluar IS NULL
    """, (jam_keluar, id_karyawan, tanggal))
    conn.commit()

    messagebox.showinfo("Berhasil", f"Clock Out berhasil pada {jam_keluar}")
    tampilkan_info(karyawan)

def keluar():
    tampilkan_form_absen()


def clock_in():
    id_karyawan = entry_id.get().strip()
    if not id_karyawan:
        messagebox.showwarning("Input Kosong", "Silakan masukkan ID Karyawan!")
        return

    try:
        cursor.execute("""
            SELECT * FROM Karyawan k JOIN Jabatan j ON k.id_jabatan = j.id_jabatan
            WHERE id_karyawan = %s
        """, (id_karyawan,))
        karyawan = cursor.fetchone()

        if not karyawan:
            messagebox.showerror("Tidak Ditemukan", "ID Karyawan tidak valid.")
            return

        tanggal = datetime.now().strftime('%Y-%m-%d')
        jam_masuk = datetime.now().strftime('%H:%M:%S')

        cursor.execute("""
            SELECT * FROM Absensi
            WHERE id_karyawan = %s AND tanggal = %s
        """, (id_karyawan, tanggal))
        sudah_absen = cursor.fetchone()

        if sudah_absen:
            messagebox.showerror("Sudah Clock In", "Karyawan ini sudah melakukan clock in hari ini.")
            tampilkan_info(karyawan)
            return

        cursor.execute("""
            INSERT INTO Absensi (id_karyawan, tanggal, jam_masuk, jam_keluar)
            VALUES (%s, %s, %s, NULL)
        """, (id_karyawan, tanggal, jam_masuk))
        conn.commit()

        messagebox.showinfo("Berhasil", f"Clock In berhasil pada {jam_masuk}")
        tampilkan_info(karyawan)

    except mysql.connector.Error as e:
        messagebox.showerror("Database Error", f"Terjadi kesalahan database: {e}")
    except Exception as e:
        messagebox.showerror("Error", f"Terjadi kesalahan: {e}")

def clock_out():
    id_karyawan = entry_id.get().strip()
    if not id_karyawan:
        messagebox.showwarning("Input Kosong", "Silakan masukkan ID Karyawan!")
        return

    try:
        cursor.execute("""
            SELECT * FROM Karyawan k JOIN Jabatan j ON k.id_jabatan = j.id_jabatan
            WHERE id_karyawan = %s
        """, (id_karyawan,))
        karyawan = cursor.fetchone()

        if not karyawan:
            messagebox.showerror("Tidak Ditemukan", "ID Karyawan tidak valid.")
            return

        tanggal = datetime.now().strftime('%Y-%m-%d')
        jam_keluar = datetime.now().strftime('%H:%M:%S')

        cursor.execute("""
            SELECT * FROM Absensi
            WHERE id_karyawan = %s AND tanggal = %s AND jam_keluar IS NULL
        """, (id_karyawan, tanggal))
        absen_hari_ini = cursor.fetchone()

        if not absen_hari_ini:
            messagebox.showerror("Belum Clock In", "Karyawan ini belum melakukan clock in hari ini atau sudah clock out.")
            return

        cursor.execute("""
            UPDATE Absensi SET jam_keluar = %s
            WHERE id_karyawan = %s AND tanggal = %s AND jam_keluar IS NULL
        """, (jam_keluar, id_karyawan, tanggal))
        conn.commit()

        messagebox.showinfo("Berhasil", f"Clock Out berhasil pada {jam_keluar}")
        tampilkan_info(karyawan)

    except mysql.connector.Error as e:
        messagebox.showerror("Database Error", f"Terjadi kesalahan database: {e}")
    except Exception as e:
        messagebox.showerror("Error", f"Terjadi kesalahan: {e}")

# ======== GUI ========
root = tk.Tk()
root.title("Absensi Karyawan")
root.geometry("520x540")
root.resizable(False, False)
root.configure(bg="#f4f6fb")

# ===== Style =====
FONT_TITLE = ("Segoe UI", 18, "bold")
FONT_LABEL = ("Segoe UI", 12)
FONT_ENTRY = ("Segoe UI", 12)
FONT_BUTTON = ("Segoe UI", 11, "bold")
FONT_TEXT = ("Consolas", 10)

# ===== Frame 1: Form Absensi =====
frame_absen = tk.Frame(root, bg="#f4f6fb")
tk.Label(frame_absen, text="ABSENSI KARYAWAN", font=FONT_TITLE, bg="#f4f6fb", fg="#2d4059").pack(pady=(30,10))
tk.Label(frame_absen, text="Masukkan ID Karyawan:", font=FONT_LABEL, bg="#f4f6fb").pack(pady=(10,5))
entry_id = tk.Entry(frame_absen, font=FONT_ENTRY, width=18, bd=2, relief="groove")
entry_id.pack(pady=(0,15))

# Frame untuk tombol clock in dan clock out
frame_buttons = tk.Frame(frame_absen, bg="#f4f6fb")
frame_buttons.pack(pady=(0,20))

tk.Button(
    frame_buttons, text="Clock In", bg="#30a14e", fg="white", font=FONT_BUTTON,
    activebackground="#22863a", activeforeground="white", width=12, height=2, bd=0,
    command=clock_in, cursor="hand2"
).pack(side="left", padx=(0,10))

tk.Button(
    frame_buttons, text="Clock Out", bg="#e84545", fg="white", font=FONT_BUTTON,
    activebackground="#b71c1c", activeforeground="white", width=12, height=2, bd=0,
    command=clock_out, cursor="hand2"
).pack(side="right", padx=(10,0))

# ===== Frame 2: Informasi Karyawan =====
frame_info = tk.Frame(root, bg="#f4f6fb")
tk.Label(frame_info, text="INFORMASI KARYAWAN", font=FONT_TITLE, bg="#f4f6fb", fg="#2d4059").pack(pady=(20,10))
text_info = tk.Text(frame_info, height=18, width=60, font=FONT_TEXT, state="disabled", bg="#f9fafc", bd=1, relief="solid")
text_info.pack(padx=15, pady=10)
tk.Button(
    frame_info, text="Keluar (Absen Karyawan Lain)", bg="#6c757d", fg="white", font=FONT_BUTTON,
    activebackground="#5a6268", activeforeground="white", width=25, height=2, bd=0,
    command=keluar, cursor="hand2"
).pack(pady=(5,20))

# ===== Tampilkan Form Awal =====
tampilkan_form_absen()

root.mainloop()