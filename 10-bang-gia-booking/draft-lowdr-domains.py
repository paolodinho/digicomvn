#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""Chuyen dong gia sang DRAFT cho domain DR<=5 (Ahrefs, mien phi, 2026-07-19) - tin hieu
nghi van site rac/it traffic. Khop theo domain chuan hoa tu title bai dang tren live."""
import csv, json, re, os

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

low = set()
for r in csv.DictReader(open(os.path.join(BASE, "report-dr-low.csv"))):
    low.add(domain(r["domain"]).lower())

live = json.load(open(os.path.join(BASE, "live-now-fresh.json")))
draft_ids = []
matched = set()
for p in live:
    d = domain(p["title"]).lower()
    if d in low:
        draft_ids.append(p["ID"])
        matched.add(d)

print(f"Domain DR<=5: {len(low)}")
print(f"Khop voi post dang publish: {len(matched)} domain -> {len(draft_ids)} dong gia se DRAFT")
print(f"Khong khop (co the da draft tu buoc truoc / ten khac): {len(low - matched)}")
for d in sorted(low - matched)[:15]:
    print("  ", d)

json.dump(draft_ids, open(os.path.join(BASE, "draft-lowdr-ids.json"), "w"))
