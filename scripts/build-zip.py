"""Package theme/ as deploy/liquid-landing-theme.zip (forward-slash paths, ready for wp-admin upload)."""
import os, zipfile
root = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
os.makedirs(os.path.join(root, "deploy"), exist_ok=True)
dst = os.path.join(root, "deploy", "liquid-landing.zip")
with zipfile.ZipFile(dst, "w", zipfile.ZIP_DEFLATED) as z:
    for cur, _, files in os.walk(os.path.join(root, "theme")):
        for f in files:
            p = os.path.join(cur, f)
            z.write(p, "liquid-landing/" + os.path.relpath(p, os.path.join(root, "theme")).replace(os.sep, "/"))
print("wrote", dst, round(os.path.getsize(dst) / 1e6, 2), "MB")
