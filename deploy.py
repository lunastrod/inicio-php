import os
import ftplib
from pathlib import Path
import dotenv

dotenv.load_dotenv()

FTP_HOST = os.getenv("FTP_HOST")
FTP_USER = os.getenv("FTP_USER")
FTP_PASS = os.getenv("FTP_PASS")

LOCAL_DIR = "./htdocs"
REMOTE_DIR = "/htdocs"

def upload_directory(ftp, local_path, remote_path):
    for item in os.listdir(local_path):
        l_path = os.path.join(local_path, item)
        r_path = os.path.join(remote_path, item).replace("\\", "/")

        if os.path.isfile(l_path):
            print(f"Uploading: {l_path} -> {r_path}")
            with open(l_path, "rb") as f:
                ftp.storbinary(f"STOR {r_path}", f)
        elif os.path.isdir(l_path):
            try:
                ftp.mkd(r_path)
                print(f"Created directory: {r_path}")
            except ftplib.error_perm:
                pass
            upload_directory(ftp, l_path, r_path)

def main():
    if not os.path.exists(LOCAL_DIR):
        print(f"ERROR: Local directory {LOCAL_DIR} does not exist.")
        return

    print(f"Connecting to {FTP_HOST}...")
    try:
        ftp = ftplib.FTP_TLS(FTP_HOST) 
        ftp.login(FTP_USER, FTP_PASS)
        
        ftp.prot_p() 
        
        print("Connection successful. Starting upload...")
        upload_directory(ftp, LOCAL_DIR, REMOTE_DIR)
        
        ftp.quit()
        print("\nDeployment finished successfully!")
    except Exception as e:
        print(f"\nERROR: {e}")

if __name__ == "__main__":
    main()