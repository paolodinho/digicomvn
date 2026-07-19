#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""Chuyen dong gia sang DRAFT cho domain KHONG RESOLVE DNS (DEAD_DOMAIN, dang tin cay cao nhat
tu report-link-status.csv, 2026-07-19). Khop theo domain chuan hoa tu title bai dang tren live
(live-now-fresh.json) - domain chet o dau_bao nao thi draft MOI dong gia cua domain do (moi
dich_vu), vi ten mien da khong con hoat dong noi chung, khong rieng 1 dich vu."""
import csv, json, re, unicodedata, os

BASE = os.path.dirname(os.path.abspath(__file__))
DOMAIN_RE = re.compile(r"^(https?://)?(www\.)?[a-z0-9-]+(\.[a-z0-9-]+)+(/|$)", re.I)

def domain(s):
    s = (s or "").strip()
    if not DOMAIN_RE.match(s):
        return s
    v = s.lower()
    v = re.sub(r"^https?://", "", v)
    v = re.sub(r"^www\.", "", v)
    return v.split("/")[0].strip()

dead = set()
for r in csv.DictReader(open(os.path.join(BASE, "report-link-status.csv"))):
    if r["trang_thai"] == "DEAD_DOMAIN":
        dead.add(domain(r["domain"]).lower())

live = json.load(open(os.path.join(BASE, "live-now-fresh.json")))
draft_ids = []
matched_dom = set()
for p in live:
    d = domain(p["title"]).lower()
    if d in dead:
        draft_ids.append(p["ID"])
        matched_dom.add(d)

print(f"Domain DEAD_DOMAIN: {len(dead)}")
print(f"Khop duoc voi post dang publish tren live: {len(matched_dom)} domain -> {len(draft_ids)} dong gia se chuyen DRAFT")
print(f"Domain DEAD nhung KHONG thay dong gia dang publish nao (co the da draft san / ten khong khop title): {len(dead - matched_dom)}")
for d in sorted(dead - matched_dom)[:15]:
    print("  ", d)

json.dump(draft_ids, open(os.path.join(BASE, "draft-dead-ids.json"), "w"))
