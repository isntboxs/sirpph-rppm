<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SiRPPH - PAUDQu AL-AULIA</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root{
  --g9:#0d1f15;--g8:#152b1f;--g7:#1e3d2b;--g6:#2d6a4f;--g5:#40916c;--g4:#52b788;
  --g3:#74c69d;--g2:#b7e4c7;--g1:#d8f3dc;--g0:#f4f7f5;
  --acc:#f4a261;--acc2:#e76f51;--red:#e63946;--blue:#4361ee;
  --purple:#7b2d8b;--pink:#e91e8c;--gold:#f5cc5a;--sky:#0ea5e9;
  --txt:#1a2e22;--txt2:#3d5a47;--txt3:#6b8a77;
  --white:#fff;--sh:0 2px 12px rgba(0,0,0,.08);--sh2:0 6px 24px rgba(0,0,0,.14);
  --r:12px;--r2:8px;--r3:20px;--sw:258px;
}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Nunito',sans-serif;background:var(--g0);color:var(--txt);min-height:100vh}
button{cursor:pointer;border:none;font-family:inherit}
input,select,textarea{font-family:inherit;outline:none}
h1,h2,h3,h4{font-family:'Plus Jakarta Sans',sans-serif}

/* LOGIN */
#lp{display:flex;min-height:100vh;background:var(--g8);overflow:hidden;position:relative}
#lp::before{content:'';position:absolute;inset:0;
  background:radial-gradient(ellipse at 20% 50%,rgba(64,145,108,.25) 0%,transparent 60%),
             radial-gradient(ellipse at 80% 20%,rgba(245,204,90,.1) 0%,transparent 50%)}
.ll{flex:1;display:flex;flex-direction:column;justify-content:center;padding:60px;z-index:1}
.ll h1{font-size:52px;font-weight:800;color:var(--white);line-height:1;margin-bottom:12px}
.ll h1 span{color:var(--gold)}
.ll p{color:rgba(255,255,255,.55);font-size:15px;line-height:1.7;max-width:400px;margin-bottom:28px}
.role-chips{display:grid;grid-template-columns:1fr 1fr;gap:10px;max-width:380px}
.rc{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:10px;
  padding:12px 14px;display:flex;align-items:center;gap:10px}
.rc-ico{font-size:20px}.rc-nm{font-size:12px;font-weight:700;color:rgba(255,255,255,.8)}
.rc-ds{font-size:10.5px;color:rgba(255,255,255,.35);margin-top:1px}
.lr{width:400px;background:var(--white);display:flex;align-items:center;justify-content:center;padding:36px;z-index:1}
.lc{width:100%}
.lb{margin-bottom:28px}
.lb .bm{width:52px;height:52px;background:linear-gradient(135deg,var(--g6),var(--g4));border-radius:14px;
  display:flex;align-items:center;justify-content:center;font-size:24px;margin-bottom:14px;
  box-shadow:0 8px 20px rgba(45,106,79,.3)}
.lb h2{font-size:24px;font-weight:800;color:var(--txt)}
.lb p{font-size:12.5px;color:var(--txt3);margin-top:3px}
.fg{margin-bottom:16px}
.fg label{display:block;font-size:11px;font-weight:700;color:var(--txt2);margin-bottom:6px;
  text-transform:uppercase;letter-spacing:.5px}
.fg input,.fg select{width:100%;padding:11px 13px;border:2px solid var(--g1);border-radius:var(--r2);
  font-size:13.5px;background:var(--g0);transition:.2s;color:var(--txt)}
.fg input:focus,.fg select:focus{border-color:var(--g5);background:var(--white)}
.btn-login{width:100%;padding:13px;background:linear-gradient(135deg,var(--g7),var(--g5));color:var(--white);
  border-radius:var(--r2);font-size:14px;font-weight:700;transition:.2s;
  box-shadow:0 4px 14px rgba(45,106,79,.3)}
.btn-login:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(45,106,79,.4)}
.demos{margin-top:20px;background:var(--g0);border-radius:var(--r2);padding:14px}
.demos p{font-size:10.5px;font-weight:700;color:var(--txt3);text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px}
.dg{display:grid;grid-template-columns:1fr 1fr;gap:7px}
.db{padding:8px 10px;background:var(--white);border:1.5px solid var(--g2);border-radius:6px;
  font-size:11.5px;font-weight:700;color:var(--g7);text-align:left;line-height:1.4;transition:.15s}
.db:hover{background:var(--g1);border-color:var(--g4)}
.db span{display:block;font-size:10px;font-weight:500;color:var(--txt3);margin-top:1px}
#lerr{display:none;margin-top:10px;background:#fee2e2;color:#991b1b;padding:10px 13px;border-radius:6px;font-size:12.5px}

/* APP */
#app{display:none;min-height:100vh}
.shell{display:flex;min-height:100vh}
.sb{width:var(--sw);background:var(--g8);position:fixed;top:0;left:0;height:100vh;
  overflow-y:auto;z-index:100;display:flex;flex-direction:column}
.sbh{padding:18px 16px;border-bottom:1px solid rgba(255,255,255,.06)}
.sbb{display:flex;align-items:center;gap:10px}
.sbb .bi{width:38px;height:38px;background:linear-gradient(135deg,var(--g5),var(--g3));border-radius:10px;
  display:flex;align-items:center;justify-content:center;font-size:17px;flex-shrink:0}
.sbb h2{font-size:15px;font-weight:800;color:var(--white);line-height:1.2}
.sbb p{font-size:10px;color:rgba(255,255,255,.35);margin-top:1px}
.sbu{margin:8px 10px;background:rgba(255,255,255,.05);border-radius:var(--r2);padding:11px 13px}
.sbur{display:flex;align-items:center;gap:9px}
.sbav{width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;
  font-size:13px;font-weight:800;color:var(--white);flex-shrink:0}
.sbun{font-size:12.5px;font-weight:700;color:var(--white)}
.sbrl{font-size:10.5px;color:rgba(255,255,255,.4);margin-top:1px}
.sbn{padding:6px 10px;flex:1}
.sns{font-size:10px;font-weight:700;color:rgba(255,255,255,.22);letter-spacing:1.5px;
  text-transform:uppercase;padding:8px 8px 3px}
.ni{display:flex;align-items:center;gap:8px;padding:9px 11px;border-radius:7px;cursor:pointer;
  transition:.15s;color:rgba(255,255,255,.6);font-size:13px;font-weight:500;margin-bottom:1px;position:relative}
.ni:hover{background:rgba(255,255,255,.07);color:var(--white)}
.ni.on{background:var(--acc);color:var(--white);font-weight:700;box-shadow:0 4px 12px rgba(244,162,97,.3)}
.ni .nic{font-size:14px;width:19px;text-align:center;flex-shrink:0}
.nbg{margin-left:auto;background:var(--red);color:var(--white);border-radius:10px;
  font-size:10px;font-weight:700;padding:1px 6px;min-width:17px;text-align:center}
.sbf{padding:12px;border-top:1px solid rgba(255,255,255,.06)}
.blo{width:100%;padding:9px;background:rgba(231,111,81,.15);color:#ff9f80;border-radius:7px;
  font-size:12px;font-weight:600;transition:.2s;display:flex;align-items:center;justify-content:center;gap:7px}
.blo:hover{background:rgba(231,111,81,.28)}

/* TOPBAR & MAIN */
.mn{margin-left:var(--sw);flex:1;min-height:100vh;display:flex;flex-direction:column}
.tb{background:var(--white);padding:13px 26px;border-bottom:1px solid var(--g1);
  display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50;box-shadow:var(--sh)}
.tbt h2{font-size:18px;font-weight:800;color:var(--txt)}
.tbt p{font-size:11.5px;color:var(--txt3);margin-top:1px}
.tbr{display:flex;align-items:center;gap:10px}
.rbdg{padding:5px 13px;border-radius:20px;font-size:11.5px;font-weight:700}
.ra{background:#fef3c7;color:#92400e}.rk{background:#ede9fe;color:#5b21b6}
.rg{background:#d1fae5;color:#065f46}.ro{background:#dbeafe;color:#1e40af}

/* NOTIF BELL */
.notif-bell{position:relative;cursor:pointer;padding:8px;border-radius:var(--r2);
  background:var(--g0);border:1px solid var(--g2);transition:.2s}
.notif-bell:hover{background:var(--g1)}
.notif-count{position:absolute;top:-4px;right:-4px;background:var(--red);color:var(--white);
  border-radius:50%;width:18px;height:18px;font-size:10px;font-weight:700;
  display:flex;align-items:center;justify-content:center}

/* NOTIF DROPDOWN */
.notif-dropdown{position:absolute;top:calc(100% + 8px);right:0;width:320px;background:var(--white);
  border-radius:var(--r);box-shadow:var(--sh2);border:1px solid var(--g1);z-index:200;display:none}
.notif-dropdown.show{display:block}
.nd-head{padding:14px 16px;border-bottom:1px solid var(--g1);font-weight:700;font-size:13px;
  display:flex;align-items:center;justify-content:space-between}
.nd-item{padding:12px 16px;border-bottom:1px solid var(--g0);cursor:pointer;transition:.15s}
.nd-item:hover{background:var(--g0)}
.nd-item.unread{background:#f0fdf4}
.nd-title{font-size:12.5px;font-weight:700;color:var(--txt)}
.nd-msg{font-size:11.5px;color:var(--txt3);margin-top:2px;line-height:1.4}
.nd-time{font-size:10.5px;color:var(--txt3);margin-top:4px}
.nd-empty{padding:24px;text-align:center;color:var(--txt3);font-size:12.5px}

.ca{padding:24px}

/* CARDS */
.card{background:var(--white);border-radius:var(--r);padding:20px;box-shadow:var(--sh);border:1px solid var(--g1)}
.ch{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px}
.ct{font-size:14.5px;font-weight:700;color:var(--txt)}
.cs{font-size:11.5px;color:var(--txt3);margin-top:2px}

/* STATS */
.sg{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:12px;margin-bottom:18px}
.sc{background:var(--white);border-radius:var(--r);padding:16px;box-shadow:var(--sh);
  border:1px solid var(--g1);display:flex;align-items:center;gap:13px}
.sico{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:19px;flex-shrink:0}
.sico.gr{background:var(--g1)}.sico.or{background:#fff0e6}.sico.bl{background:#dbeafe}
.sico.pu{background:#f3e8ff}.sico.pk{background:#fce7f3}.sico.go{background:#fef9c3}
.sv{font-size:24px;font-weight:800;color:var(--txt);line-height:1}
.sl{font-size:11px;color:var(--txt3);margin-top:3px;font-weight:600}

/* BUTTONS */
.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--r2);
  font-size:12.5px;font-weight:700;transition:.18s;font-family:inherit;white-space:nowrap}
.bp{background:var(--g6);color:var(--white)}.bp:hover{background:var(--g7);transform:translateY(-1px)}
.ba{background:var(--acc);color:var(--white)}.ba:hover{background:var(--acc2)}
.bo{background:transparent;color:var(--g6);border:2px solid var(--g2)}.bo:hover{background:var(--g0);border-color:var(--g4)}
.bd{background:#fff0f0;color:var(--red);border:1px solid #ffd5d5}.bd:hover{background:#ffe0e0}
.bpu{background:#f3e8ff;color:var(--purple);border:1px solid #ddd6fe}
.bsk{background:#e0f2fe;color:#0369a1}
.bsm{padding:6px 13px;font-size:11.5px}.bxs{padding:4px 9px;font-size:11px}

/* TABLE */
.tw{overflow-x:auto;border-radius:var(--r2)}
table{width:100%;border-collapse:collapse;font-size:12.5px}
thead tr{background:var(--g0)}
th{padding:10px 13px;text-align:left;font-size:10px;font-weight:700;color:var(--txt3);
  letter-spacing:.7px;text-transform:uppercase;border-bottom:2px solid var(--g1)}
td{padding:10px 13px;border-bottom:1px solid var(--g0);vertical-align:middle}
tr:last-child td{border-bottom:none}tr:hover td{background:#fafcfb}

/* BADGES */
.bdg{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700}
.bok{background:#dcfce7;color:#166534}.bpnd{background:#fef9c3;color:#854d0e}
.bdr{background:#f1f5f9;color:#475569}.brj{background:#fee2e2;color:#991b1b}
.blk{background:#fce7f3;color:#9d174d}.bnw{background:#f0fdf4;color:#166534;border:1px solid #bbf7d0}

/* ASPEK */
.ap{display:inline-flex;align-items:center;gap:3px;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600}
.a1{background:#f3e8ff;color:#6b21a8}.a2{background:#dbeafe;color:#1e40af}
.a3{background:#fef9c3;color:#92400e}.a4{background:#dcfce7;color:#166534}
.a5{background:#fce7f3;color:#9d174d}.a6{background:#fff7ed;color:#c2410c}
.pbc=['gr','bl','ye','gr','pk','or'];

/* FORMS */
.fr{display:grid;gap:13px;margin-bottom:13px}
.fr.c2{grid-template-columns:1fr 1fr}.fr.c3{grid-template-columns:1fr 1fr 1fr}
.ff label{display:block;font-size:10.5px;font-weight:700;color:var(--txt2);margin-bottom:5px;
  text-transform:uppercase;letter-spacing:.5px}
.ff input,.ff select,.ff textarea{width:100%;padding:9px 12px;border:2px solid var(--g1);
  border-radius:var(--r2);font-size:13px;transition:.2s;background:var(--white);color:var(--txt)}
.ff input:focus,.ff select:focus,.ff textarea:focus{border-color:var(--g5);box-shadow:0 0 0 3px rgba(45,106,79,.1)}
.ff textarea{resize:vertical;min-height:75px}
.ff input:disabled,.ff select:disabled{background:var(--g0);color:var(--txt3)}

/* MODALS */
.mo{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:1000;
  align-items:center;justify-content:center;padding:16px;backdrop-filter:blur(3px)}
.mo.on{display:flex}
.md{background:var(--white);border-radius:var(--r3);width:100%;max-height:92vh;overflow-y:auto;animation:mdin .2s ease}
.msm{max-width:400px}.mmd{max-width:580px}.mlg{max-width:780px}.mxl{max-width:980px}
.mh{padding:20px 24px 0;display:flex;align-items:flex-start;justify-content:space-between}
.mt2{font-size:18px;font-weight:800;color:var(--txt)}.mst{font-size:12px;color:var(--txt3);margin-top:3px}
.mc{width:32px;height:32px;border-radius:50%;background:var(--g0);color:var(--txt3);
  font-size:15px;display:flex;align-items:center;justify-content:center;transition:.2s;flex-shrink:0}
.mc:hover{background:var(--g1)}
.mb{padding:20px 24px}.mf{padding:0 24px 20px;display:flex;align-items:center;justify-content:flex-end;gap:9px}

/* ALERTS */
.al{padding:10px 13px;border-radius:var(--r2);font-size:12.5px;margin-bottom:12px;display:flex;align-items:flex-start;gap:8px}
.alw{background:#fff7ed;color:#c2410c;border:1px solid #fed7aa}
.ali{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe}
.als{background:#f0fdf4;color:#166534;border:1px solid #bbf7d0}
.ale{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}
.alp{background:#faf5ff;color:#6b21a8;border:1px solid #e9d5ff}

/* PROGRESS */
.pw{background:var(--g1);border-radius:10px;height:7px;overflow:hidden}
.pb{height:100%;border-radius:10px;transition:.5s}
.pb.gr{background:var(--g5)}.pb.or{background:var(--acc)}.pb.bl{background:var(--blue)}
.pb.pu{background:var(--purple)}.pb.pk{background:var(--pink)}.pb.ye{background:#eab308}

/* RPP CARD */
.rc2{border:2px solid var(--g1);border-radius:var(--r);padding:16px;margin-bottom:9px;
  transition:.18s;background:var(--white)}
.rc2:hover{border-color:var(--g3);box-shadow:var(--sh)}
.rh{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:9px}
.rw{font-size:11.5px;color:var(--txt3);font-weight:600}
.rn{font-size:14px;font-weight:800;color:var(--txt);margin-top:2px}
.rs{font-size:12px;color:var(--g6);margin-top:2px;font-weight:600}
.ract{display:flex;gap:7px;margin-top:10px;flex-wrap:wrap}

/* TABS */
.tabs{display:flex;border-bottom:2px solid var(--g1);margin-bottom:20px}
.tbn{padding:9px 17px;font-size:13px;font-weight:600;color:var(--txt3);cursor:pointer;
  border-bottom:3px solid transparent;margin-bottom:-2px;transition:.18s;background:none;border-radius:0}
.tbn.on{color:var(--g6);border-bottom-color:var(--g6)}

/* FILTER */
.fb{display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:16px}
.fb input,.fb select{padding:8px 12px;border:2px solid var(--g1);border-radius:var(--r2);
  font-size:12px;background:var(--white);transition:.2s;min-width:140px}
.fb input:focus,.fb select:focus{border-color:var(--g5)}

/* DAY TABS */
.dt{display:flex;gap:6px;margin-bottom:13px;flex-wrap:wrap}
.dtb{padding:7px 15px;border-radius:20px;font-size:12px;font-weight:600;cursor:pointer;
  transition:.18s;background:var(--g0);color:var(--txt3);border:2px solid var(--g1)}
.dtb:hover{border-color:var(--g4)}.dtb.on{background:var(--g6);color:var(--white);border-color:var(--g6)}
.dtb.fl{background:var(--g1);color:var(--g7);border-color:var(--g3)}
.dtb.fl.on{background:var(--g6);color:var(--white)}

/* KEGIATAN CARD */
.kc{border:2px solid var(--g1);border-radius:var(--r);padding:13px;margin-bottom:9px;
  transition:.18s;background:var(--white)}
.kc:hover{border-color:var(--g4);box-shadow:var(--sh)}
.kc.sel{border-color:var(--g5);background:#f0fdf4}
.kc.lck{border-color:#fecaca;background:#fff5f5}
.kn{font-weight:700;font-size:13px;margin-bottom:5px;color:var(--txt)}
.kd{font-size:12px;color:var(--txt3);line-height:1.5;margin-bottom:7px}

/* DAY SCHEDULE */
.ds{background:var(--g0);border:1px solid var(--g1);border-radius:var(--r2);padding:12px;margin-bottom:7px}
.dsh{display:flex;align-items:center;justify-content:space-between;margin-bottom:8px}
.dn{font-size:12px;font-weight:700;color:var(--g7)}
.dki{background:var(--white);border:1px solid var(--g2);border-radius:6px;padding:7px 10px;
  font-size:12px;display:flex;align-items:center;justify-content:space-between;margin-bottom:4px}

/* PORTFOLIO */
.pfc{background:var(--white);border:2px solid var(--g1);border-radius:var(--r);overflow:hidden;transition:.2s}
.pfc:hover{border-color:var(--g3);box-shadow:var(--sh2)}
.pfp{height:140px;display:flex;align-items:center;justify-content:center;font-size:48px}
.pfb{padding:13px}
.pfn{font-size:13.5px;font-weight:700;color:var(--txt)}
.pfd{font-size:11px;color:var(--txt3);margin-top:2px}
.pfnt{font-size:12px;color:var(--txt2);margin-top:7px;line-height:1.5}

/* KOMENTAR */
.kom-item{background:var(--g0);border-radius:var(--r2);padding:10px 13px;margin-top:8px}
.kom-author{font-size:11.5px;font-weight:700;color:var(--g7)}
.kom-text{font-size:12px;color:var(--txt2);margin-top:3px;line-height:1.5}
.kom-time{font-size:10.5px;color:var(--txt3);margin-top:3px}

/* GRAFIK */
.graf-bar{display:flex;align-items:center;gap:10px;margin-bottom:10px}
.graf-label{font-size:12px;font-weight:600;color:var(--txt2);width:150px;flex-shrink:0}
.graf-wrap{flex:1;background:var(--g1);border-radius:10px;height:22px;overflow:hidden;position:relative}
.graf-fill{height:100%;border-radius:10px;transition:.6s;display:flex;align-items:center;padding-left:8px}
.graf-val{font-size:11px;font-weight:700;color:var(--white)}
.graf-pct{font-size:11.5px;font-weight:700;color:var(--txt2);width:36px;text-align:right}

/* PROSEM */
.pt{width:100%;border-collapse:collapse;font-size:12px}
.pt th{background:var(--g8);color:var(--white);padding:9px 13px;text-align:center;
  border:1px solid var(--g7);font-size:10.5px;letter-spacing:.5px;text-transform:uppercase}
.pt td{border:1px solid var(--g2);padding:7px 11px;vertical-align:middle}
.pt tr:nth-child(even) td{background:var(--g0)}
.pt td.tc{background:var(--g1);font-weight:700;color:var(--g8);text-align:center}
.wn{width:30px;height:30px;background:var(--g6);color:var(--white);border-radius:50%;
  display:flex;align-items:center;justify-content:center;font-size:11.5px;font-weight:700;margin:0 auto}

/* INFO */
.ig{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:11px}
.ib{background:var(--g0);border-radius:var(--r2);padding:12px 15px;border-left:4px solid var(--g4)}
.ik{font-size:10px;font-weight:700;color:var(--txt3);text-transform:uppercase;letter-spacing:.5px}
.iv{font-size:13px;font-weight:700;color:var(--txt);margin-top:3px}

/* REKOMENDASI BOX */
.rek-box{background:linear-gradient(135deg,#f0fdf4,#dcfce7);border:2px solid var(--g3);
  border-radius:var(--r);padding:16px;margin-top:12px}
.rek-title{font-size:13px;font-weight:700;color:var(--g7);margin-bottom:10px}
.rek-item{background:var(--white);border:1px solid var(--g2);border-radius:var(--r2);
  padding:10px 13px;margin-bottom:7px;cursor:pointer;transition:.18s}
.rek-item:hover{border-color:var(--g4);background:var(--g0)}

/* CHECKBOX */
.cbg{display:flex;flex-wrap:wrap;gap:7px}
.cbi{display:flex;align-items:center;gap:5px;padding:5px 11px;border:2px solid var(--g1);
  border-radius:20px;cursor:pointer;transition:.18s;font-size:12px;font-weight:600}
.cbi:hover{border-color:var(--g4)}.cbi.ck{background:var(--g1);border-color:var(--g4);color:var(--g8)}
.cbi input{accent-color:var(--g6);width:13px;height:13px}

/* PRINT */
.pra{font-family:'Times New Roman',serif;font-size:12px;line-height:1.6;color:#000}
.prt{border-collapse:collapse;width:100%;font-size:12px}
.prt th,.prt td{border:1px solid #000;padding:7px;vertical-align:top}
.prt th{background:#f0f0f0;font-weight:bold;text-align:center}
.sgn{display:grid;grid-template-columns:1fr 1fr;gap:40px;margin-top:36px;text-align:center}
.sn{font-weight:bold;text-decoration:underline;margin-top:56px}

/* TOAST */
#toast{position:fixed;bottom:20px;right:20px;z-index:9999;display:none;
  color:var(--white);padding:12px 16px;border-radius:var(--r2);font-size:13px;font-weight:600;
  box-shadow:var(--sh2);max-width:300px;animation:fup .3s ease}

/* EMPTY */
.emp{text-align:center;padding:44px 20px;color:var(--txt3)}
.emp .ei{font-size:42px;margin-bottom:12px}.emp h3{font-size:16px;font-weight:700;color:var(--txt2);margin-bottom:6px}

/* MISC */
.dv{border:none;border-top:1px solid var(--g1);margin:16px 0}
.g2{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.g3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px}
.g4{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:12px}
.fl{display:flex}.fw{flex-wrap:wrap}.ic{align-items:center}.jb{justify-content:space-between}
.g8{gap:8px}.g12{gap:12px}.mt8{margin-top:8px}.mt16{margin-top:16px}.mt24{margin-top:24px}
.mb8{margin-bottom:8px}.mb16{margin-bottom:16px}.fw7{font-weight:700}
.fs11{font-size:11.5px}.tc2{color:var(--txt3)}.wf{width:100%}
@keyframes fup{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
@keyframes mdin{from{opacity:0;transform:scale(.95)}to{opacity:1;transform:scale(1)}}
@keyframes sin{from{opacity:0;transform:translateX(-8px)}to{opacity:1;transform:translateX(0)}}
.pg{display:none}.pg.on{display:block;animation:sin .2s ease}
::-webkit-scrollbar{width:5px;height:5px}::-webkit-scrollbar-thumb{background:var(--g2);border-radius:3px}
</style>
<body>

<!-- ===================== LOGIN ===================== -->
<div id="lp">
  <div class="ll">
    <h1>Si<span>RPPH</span></h1>
    <p>Sistem Informasi Penyusunan RPP & RPPH<br>PAUDQu AL-AULIA — Kota Serang</p>
    <div class="role-chips">
      <div class="rc"><div class="rc-ico">⚙️</div><div><div class="rc-nm">Admin/Operator</div><div class="rc-ds">Kelola data master</div></div></div>
      <div class="rc"><div class="rc-ico">👑</div><div><div class="rc-nm">Kepala Sekolah</div><div class="rc-ds">Validasi & PROSEM</div></div></div>
      <div class="rc"><div class="rc-ico">🧑‍🏫</div><div><div class="rc-nm">Guru</div><div class="rc-ds">Buat RPP & RPPH</div></div></div>
      <div class="rc"><div class="rc-ico">👨‍👩‍👧</div><div><div class="rc-nm">Orang Tua</div><div class="rc-ds">Pantau anak</div></div></div>
    </div>
  </div>
  <div class="lr">
    <div class="lc">
      <div class="lb">
        <div class="bm">📚</div>
        <h2>Masuk ke SiRPPH</h2>
        <p>PAUDQu AL-AULIA — Tahun Ajaran 2024/2025</p>
      </div>
      <div class="fg"><label>Username</label><input placeholder="Username"/></div>
      <div class="fg"><label>Password</label><input type="password" placeholder="Password"/></div>
      <div class="fg"><label>Masuk Sebagai</label>
        <select>
          <option>⚙️ Admin / Operator</option>
          <option>👑 Kepala Sekolah</option>
          <option>🧑‍🏫 Guru</option>
          <option>👨‍👩‍👧 Orang Tua</option>
        </select>
      </div>
      <button class="btn-login">🔐 Masuk ke Sistem</button>
      <div class="demos">
        <p>Akun Demo</p>
        <div class="dg">
          <button class="db">⚙️ Admin<span>admin / admin123</span></button>
          <button class="db">👑 Kepala Sekolah<span>kepala / kepala123</span></button>
          <button class="db">🧑‍🏫 Guru Kelas A<span>guru_a / guru123</span></button>
          <button class="db">👨‍👩‍👧 Orang Tua<span>ortu1 / ortu123</span></button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ===================== APP SHELL ===================== -->
<div id="app">
  <div class="shell">

    <!-- SIDEBAR -->
    <aside class="sb">
      <div class="sbh">
        <div class="sbb">
          <div class="bi">📚</div>
          <div><h2>SiRPPH</h2><p>PAUDQu AL-AULIA</p></div>
        </div>
      </div>
      <div class="sbu">
        <div class="sbur">
          <div class="sbav" style="background:var(--g5)">A</div>
          <div><div class="sbun">Admin</div><div class="sbrl">Operator</div></div>
        </div>
      </div>
      <nav class="sbn">
        <div class="sns">Menu Utama</div>
        <a class="ni on" href="#beranda"><span class="nic">🏠</span> Beranda</a>
        <a class="ni" href="#pengguna"><span class="nic">👥</span> Kelola Pengguna</a>
        <a class="ni" href="#siswa"><span class="nic">👶</span> Data Siswa</a>
        <a class="ni" href="#ta"><span class="nic">📅</span> Tahun Ajaran</a>
        <a class="ni" href="#sekolah"><span class="nic">🏫</span> Data Sekolah</a>
        <div class="sns">Kepala Sekolah</div>
        <a class="ni" href="#prosem"><span class="nic">📊</span> PROSEM</a>
        <a class="ni" href="#tema"><span class="nic">📚</span> Kelola Tema</a>
        <a class="ni" href="#master"><span class="nic">🔧</span> Master Bentuk & Alat</a>
        <a class="ni" href="#vrppm"><span class="nic">✅</span> Validasi RPP <span class="nbg">3</span></a>
        <a class="ni" href="#vrpph"><span class="nic">📄</span> Validasi RPPH <span class="nbg">2</span></a>
        <a class="ni" href="#vkeg"><span class="nic">🗂️</span> Validasi Kegiatan <span class="nbg">1</span></a>
        <a class="ni" href="#monitoring"><span class="nic">📈</span> Monitoring Guru</a>
        <div class="sns">Guru</div>
        <a class="ni" href="#keg"><span class="nic">🗂️</span> Kumpulan Kegiatan</a>
        <a class="ni" href="#rppm"><span class="nic">📋</span> Buat & Kelola RPP</a>
        <a class="ni" href="#rpph"><span class="nic">📅</span> Buat & Kelola RPPH</a>
        <a class="ni" href="#porto"><span class="nic">📸</span> Portofolio Siswa</a>
        <a class="ni" href="#analisis"><span class="nic">📊</span> Analisis Aspek</a>
        <div class="sns">Orang Tua</div>
        <a class="ni" href="#ortu-rppm"><span class="nic">📝</span> Lihat RPP</a>
        <a class="ni" href="#ortu-rpph"><span class="nic">📄</span> Lihat RPPH</a>
        <a class="ni" href="#ortu-porto"><span class="nic">📸</span> Portofolio Anak</a>
      </nav>
      <div class="sbf"><button class="blo">🚪 Keluar</button></div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="mn">

      <!-- TOPBAR -->
      <div class="tb">
        <div class="tbt"><h2 id="pageTitle">Beranda</h2><p id="pageSubtitle">PAUDQu AL-AULIA — 2024/2025</p></div>
        <div class="tbr">
          <div style="position:relative">
            <div class="notif-bell">🔔 <span class="notif-count">3</span></div>
            <div class="notif-dropdown show" style="display:none">
              <div class="nd-head"><span>Notifikasi</span><button class="btn bo bxs">Tandai semua dibaca</button></div>
              <div>
                <div class="nd-item unread"><div class="nd-title">📝 RPP Baru Menunggu</div><div class="nd-msg">Guru Kelas A mengajukan RPP "Aku, Makhluq Allah"</div><div class="nd-time">🕐 5 menit lalu</div></div>
                <div class="nd-item unread"><div class="nd-title">📄 RPPH Menunggu Validasi</div><div class="nd-msg">Guru Kelas B mengajukan RPPH hari Senin</div><div class="nd-time">🕐 1 jam lalu</div></div>
                <div class="nd-item"><div class="nd-title">✅ RPP Disetujui</div><div class="nd-msg">RPP "Tanah Airku" telah disetujui</div><div class="nd-time">🕐 Kemarin</div></div>
              </div>
            </div>
          </div>
          <span class="rbdg ra">Admin</span>
          <span style="font-size:11.5px;color:var(--txt3)">11/04/2026</span>
        </div>
      </div>

      <!-- ===== HALAMAN: BERANDA ADMIN ===== -->
      <div class="ca pg on" id="beranda">
        <div class="sg">
          <div class="sc"><div class="sico gr">🧑‍🏫</div><div><div class="sv">4</div><div class="sl">Guru Aktif</div></div></div>
          <div class="sc"><div class="sico or">👶</div><div><div class="sv">24</div><div class="sl">Total Siswa</div></div></div>
          <div class="sc"><div class="sico bl">📝</div><div><div class="sv">12</div><div class="sl">Total RPP</div></div></div>
          <div class="sc"><div class="sico pu">📸</div><div><div class="sv">48</div><div class="sl">Entri Portofolio</div></div></div>
        </div>
        <div class="g2" style="gap:14px">
          <div class="card">
            <div class="ch"><div class="ct">🏫 Data Sekolah</div><button class="btn bp bsm">Kelola</button></div>
            <div class="ig">
              <div class="ib"><div class="ik">Nama</div><div class="iv">PAUDQu AL-AULIA</div></div>
              <div class="ib"><div class="ik">NPSN</div><div class="iv">69990123</div></div>
              <div class="ib"><div class="ik">Kepala</div><div class="iv">Ustadzah Aminah, S.Pd.</div></div>
              <div class="ib"><div class="ik">Tahun Ajaran</div><div class="iv">2024/2025</div></div>
              <div class="ib"><div class="ik">Semester Aktif</div><div class="iv">Semester 1</div></div>
            </div>
          </div>
          <div class="card">
            <div class="ch"><div class="ct">👥 Pengguna</div><button class="btn bp bsm">Kelola</button></div>
            <div class="fl ic g8 mb8"><span style="font-size:20px">⚙️</span><span class="fw7">Admin</span><span class="fs11 tc2">(1 akun)</span></div>
            <div class="fl ic g8 mb8"><span style="font-size:20px">👑</span><span class="fw7">Kepala Sekolah</span><span class="fs11 tc2">(1 akun)</span></div>
            <div class="fl ic g8 mb8"><span style="font-size:20px">🧑‍🏫</span><span class="fw7">Guru</span><span class="fs11 tc2">(2 akun)</span></div>
            <div class="fl ic g8 mb8"><span style="font-size:20px">👨‍👩‍👧</span><span class="fw7">Orang Tua</span><span class="fs11 tc2">(4 akun)</span></div>
          </div>
        </div>
      </div>

      <!-- ===== HALAMAN: KELOLA PENGGUNA ===== -->
      <div class="ca pg" id="pengguna">
        <div class="card">
          <div class="ch"><div class="ct">👥 Daftar Pengguna</div><button class="btn bp bsm">+ Tambah</button></div>
          <div class="tw">
            <table>
              <thead><tr><th>Nama</th><th>Username</th><th>Role</th><th>Detail</th><th>Status</th><th>Aksi</th></tr></thead>
              <tbody>
                <tr><td><strong>Administrator</strong></td><td><code style="background:var(--g0);padding:2px 7px;border-radius:4px;font-size:11px">admin</code></td><td>⚙️ Admin</td><td>—</td><td><span class="bdg bok">✅ Aktif</span></td><td class="fl g8"><button class="btn bo bxs">✏️</button></td></tr>
                <tr><td><strong>Ustadzah Aminah, S.Pd.</strong></td><td><code style="background:var(--g0);padding:2px 7px;border-radius:4px;font-size:11px">kepala</code></td><td>👑 Kepala</td><td>—</td><td><span class="bdg bok">✅ Aktif</span></td><td class="fl g8"><button class="btn bo bxs">✏️</button><button class="btn bd bxs">🚫</button></td></tr>
                <tr><td><strong>Ustadzah Siti Rahmah</strong></td><td><code style="background:var(--g0);padding:2px 7px;border-radius:4px;font-size:11px">guru_a</code></td><td>🧑‍🏫 Guru</td><td>Kelas A</td><td><span class="bdg bok">✅ Aktif</span></td><td class="fl g8"><button class="btn bo bxs">✏️</button><button class="btn bd bxs">🚫</button></td></tr>
                <tr><td><strong>Ustadzah Dewi Nursanti</strong></td><td><code style="background:var(--g0);padding:2px 7px;border-radius:4px;font-size:11px">guru_b</code></td><td>🧑‍🏫 Guru</td><td>Kelas B</td><td><span class="bdg bok">✅ Aktif</span></td><td class="fl g8"><button class="btn bo bxs">✏️</button><button class="btn bd bxs">🚫</button></td></tr>
                <tr><td><strong>Bapak Ahmad Yusuf</strong></td><td><code style="background:var(--g0);padding:2px 7px;border-radius:4px;font-size:11px">ortu1</code></td><td>👨‍👩‍👧 Orang Tua</td><td>Zaid Al-Fatih</td><td><span class="bdg bok">✅ Aktif</span></td><td class="fl g8"><button class="btn bo bxs">✏️</button><button class="btn bd bxs">🚫</button></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ===== HALAMAN: DATA SISWA ===== -->
      <div class="ca pg" id="siswa">
        <div class="card">
          <div class="ch"><div class="ct">👶 Data Siswa</div><button class="btn bp bsm">+ Tambah Siswa</button></div>
          <div class="tw">
            <table>
              <thead><tr><th>Nama</th><th>Kelas</th><th>Tgl Lahir</th><th>JK</th><th>Portofolio</th><th>Aksi</th></tr></thead>
              <tbody>
                <tr><td><strong>Zaid Al-Fatih</strong></td><td>Kelas A</td><td>15/03/2019</td><td>👦 L</td><td>8 entri</td><td class="fl g8"><button class="btn bo bxs">✏️</button><button class="btn bd bxs">🗑️</button></td></tr>
                <tr><td><strong>Aisyah Nur Fadilah</strong></td><td>Kelas A</td><td>22/07/2019</td><td>👧 P</td><td>10 entri</td><td class="fl g8"><button class="btn bo bxs">✏️</button><button class="btn bd bxs">🗑️</button></td></tr>
                <tr><td><strong>Umar Hakim</strong></td><td>Kelas B</td><td>08/01/2019</td><td>👦 L</td><td>6 entri</td><td class="fl g8"><button class="btn bo bxs">✏️</button><button class="btn bd bxs">🗑️</button></td></tr>
                <tr><td><strong>Fatimah Az-Zahra</strong></td><td>Kelas B</td><td>30/05/2019</td><td>👧 P</td><td>9 entri</td><td class="fl g8"><button class="btn bo bxs">✏️</button><button class="btn bd bxs">🗑️</button></td></tr>
                <tr><td><strong>Ibrahim Khalil</strong></td><td>Kelas A</td><td>14/11/2018</td><td>👦 L</td><td>5 entri</td><td class="fl g8"><button class="btn bo bxs">✏️</button><button class="btn bd bxs">🗑️</button></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ===== HALAMAN: TAHUN AJARAN ===== -->
      <div class="ca pg" id="ta">
        <div class="card">
          <div class="ch"><div class="ct">📅 Tahun Ajaran</div><button class="btn bp bsm">+ Tambah</button></div>
          <div class="tw">
            <table>
              <thead><tr><th>Tahun Ajaran</th><th>Semester</th><th>Status</th><th>Aksi</th></tr></thead>
              <tbody>
                <tr><td><strong>2024/2025</strong></td><td>Semester 1</td><td><span class="bdg bok">🟢 Aktif</span></td><td><span class="fs11 tc2">Aktif</span></td></tr>
                <tr><td><strong>2023/2024</strong></td><td>Semester 2</td><td><span class="bdg bdr">⚪ Arsip</span></td><td><button class="btn bp bxs">Set Aktif</button></td></tr>
                <tr><td><strong>2022/2023</strong></td><td>Semester 2</td><td><span class="bdg bdr">⚪ Arsip</span></td><td><button class="btn bp bxs">Set Aktif</button></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ===== HALAMAN: DATA SEKOLAH ===== -->
      <div class="ca pg" id="sekolah">
        <div class="card">
          <div class="ch"><div class="ct">🏫 Data Sekolah</div><button class="btn bp bsm">✏️ Edit</button></div>
          <div class="ig">
            <div class="ib"><div class="ik">Nama Sekolah</div><div class="iv">PAUDQu AL-AULIA</div></div>
            <div class="ib"><div class="ik">NPSN</div><div class="iv">69990123</div></div>
            <div class="ib"><div class="ik">Kepala Sekolah</div><div class="iv">Ustadzah Aminah, S.Pd.</div></div>
            <div class="ib"><div class="ik">Telepon</div><div class="iv">0812-3456-7890</div></div>
            <div class="ib"><div class="ik">Tahun Ajaran</div><div class="iv">2024/2025</div></div>
            <div class="ib"><div class="ik">Semester Aktif</div><div class="iv">Semester 1</div></div>
          </div>
          <div class="ib mt16" style="border-left-color:var(--acc)"><div class="ik">Alamat</div><div class="iv">Jl. Al-Quran No.12, Serang, Banten</div></div>
        </div>
      </div>

      <!-- ===== HALAMAN: PROSEM ===== -->
      <div class="ca pg" id="prosem">
        <div class="card">
          <div class="ch"><div><div class="ct">📊 Program Semester (PROSEM)</div><div class="cs">PAUDQu AL-AULIA — 2024/2025</div></div></div>
          <div class="tabs">
            <button class="tbn on">Semester 1</button>
            <button class="tbn">Semester 2</button>
          </div>
          <div style="overflow-x:auto">
            <table class="pt">
              <thead><tr><th>No</th><th>Tema</th><th>Sub Tema</th><th>Minggu</th><th>Alokasi</th></tr></thead>
              <tbody>
                <tr><td rowspan="4" style="text-align:center;font-weight:700;border:1px solid var(--g2)">1</td><td rowspan="4" class="tc" style="border:1px solid var(--g2)">Aku, Makhluq Allah</td><td style="border:1px solid var(--g2)">Allah Tuhanku</td><td style="border:1px solid var(--g2);text-align:center"><div class="wn">1</div></td><td style="border:1px solid var(--g2);text-align:center">1 Minggu</td></tr>
                <tr><td style="border:1px solid var(--g2)">Identitasku</td><td style="border:1px solid var(--g2);text-align:center"><div class="wn">2</div></td><td style="border:1px solid var(--g2);text-align:center">1 Minggu</td></tr>
                <tr><td style="border:1px solid var(--g2)">Tubuhku / Aurat</td><td style="border:1px solid var(--g2);text-align:center"><div class="wn">3</div></td><td style="border:1px solid var(--g2);text-align:center">1 Minggu</td></tr>
                <tr><td style="border:1px solid var(--g2)">Panca Indra</td><td style="border:1px solid var(--g2);text-align:center"><div class="wn">4</div></td><td style="border:1px solid var(--g2);text-align:center">1 Minggu</td></tr>
                <tr><td rowspan="4" style="text-align:center;font-weight:700;border:1px solid var(--g2)">2</td><td rowspan="4" class="tc" style="border:1px solid var(--g2)">Tanah Airku</td><td style="border:1px solid var(--g2)">Identitas Negara</td><td style="border:1px solid var(--g2);text-align:center"><div class="wn">5</div></td><td style="border:1px solid var(--g2);text-align:center">1 Minggu</td></tr>
                <tr><td style="border:1px solid var(--g2)">Hari Besar Nasional</td><td style="border:1px solid var(--g2);text-align:center"><div class="wn">6</div></td><td style="border:1px solid var(--g2);text-align:center">1 Minggu</td></tr>
                <tr><td style="border:1px solid var(--g2)">Lambang Negara</td><td style="border:1px solid var(--g2);text-align:center"><div class="wn">7</div></td><td style="border:1px solid var(--g2);text-align:center">1 Minggu</td></tr>
                <tr><td style="border:1px solid var(--g2)">Elemen Bangsa / Budaya</td><td style="border:1px solid var(--g2);text-align:center"><div class="wn">8</div></td><td style="border:1px solid var(--g2);text-align:center">1 Minggu</td></tr>
                <tr><td colspan="4" style="border:1px solid var(--g2);text-align:center;font-weight:700;background:var(--g1)">JUMLAH</td><td style="border:1px solid var(--g2);text-align:center;font-weight:700;background:var(--g1)">17 Minggu</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ===== HALAMAN: KELOLA TEMA ===== -->
      <div class="ca pg" id="tema">
        <div class="card">
          <div class="ch"><div class="ct">📚 Kelola Tema</div><button class="btn bp bsm">+ Tambah</button></div>
          <div class="g2" style="gap:12px">
            <div class="card" style="border-color:var(--g2)">
              <div class="ch"><div><div class="ct">Aku, Makhluq Allah</div><div class="cs">Semester 1 — 4 Sub Tema</div></div><button class="btn bd bxs">🗑️</button></div>
              <div class="fl fw g8">
                <span style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Allah Tuhanku</span>
                <span style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Identitasku</span>
                <span style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Tubuhku / Aurat</span>
                <span style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Panca Indra</span>
              </div>
            </div>
            <div class="card" style="border-color:var(--g2)">
              <div class="ch"><div><div class="ct">Tanah Airku</div><div class="cs">Semester 1 — 4 Sub Tema</div></div><button class="btn bd bxs">🗑️</button></div>
              <div class="fl fw g8">
                <span style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Identitas Negara</span>
                <span style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Hari Besar Nasional</span>
                <span style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Lambang Negara</span>
                <span style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Elemen Bangsa</span>
              </div>
            </div>
            <div class="card" style="border-color:var(--g2)">
              <div class="ch"><div><div class="ct">Lingkunganku</div><div class="cs">Semester 1 — 4 Sub Tema</div></div><button class="btn bd bxs">🗑️</button></div>
              <div class="fl fw g8">
                <span style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Rumahku</span>
                <span style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Keluargaku</span>
                <span style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Masjidku</span>
                <span style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Sekolahku</span>
              </div>
            </div>
            <div class="card" style="border-color:var(--g2)">
              <div class="ch"><div><div class="ct">Binatang Ciptaan Allah</div><div class="cs">Semester 2 — 5 Sub Tema</div></div><button class="btn bd bxs">🗑️</button></div>
              <div class="fl fw g8">
                <span style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Binatang Halal/Haram</span>
                <span style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Binatang Qurban</span>
                <span style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Binatang Buas</span>
                <span style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Serangga</span>
                <span style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Binatang Air & Udara</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ===== HALAMAN: MASTER BENTUK & ALAT ===== -->
      <div class="ca pg" id="master">
        <div class="g2" style="gap:14px">
          <div class="card">
            <div class="ch"><div><div class="ct">🎭 Bentuk Kegiatan</div><div class="cs">Template pilihan guru saat buat RPPH</div></div><button class="btn bp bsm">+ Tambah</button></div>
            <div class="fl fw g8">
              <div class="fl ic g8" style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px"><span style="font-size:12px;font-weight:600">Mewarnai</span><button style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button></div>
              <div class="fl ic g8" style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px"><span style="font-size:12px;font-weight:600">Menggambar</span><button style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button></div>
              <div class="fl ic g8" style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px"><span style="font-size:12px;font-weight:600">Melukis</span><button style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button></div>
              <div class="fl ic g8" style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px"><span style="font-size:12px;font-weight:600">Menggunting</span><button style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button></div>
              <div class="fl ic g8" style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px"><span style="font-size:12px;font-weight:600">Menempel</span><button style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button></div>
              <div class="fl ic g8" style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px"><span style="font-size:12px;font-weight:600">Kolase</span><button style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button></div>
              <div class="fl ic g8" style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px"><span style="font-size:12px;font-weight:600">Finger Painting</span><button style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button></div>
              <div class="fl ic g8" style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px"><span style="font-size:12px;font-weight:600">Praktek Ibadah</span><button style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button></div>
              <div class="fl ic g8" style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px"><span style="font-size:12px;font-weight:600">Senam / Olah Raga</span><button style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button></div>
              <div class="fl ic g8" style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px"><span style="font-size:12px;font-weight:600">Bercerita</span><button style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button></div>
              <div class="fl ic g8" style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px"><span style="font-size:12px;font-weight:600">Bermain Peran</span><button style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button></div>
              <div class="fl ic g8" style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px"><span style="font-size:12px;font-weight:600">Playdough</span><button style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button></div>
            </div>
          </div>
          <div class="card">
            <div class="ch"><div><div class="ct">🔧 Alat & Bahan</div><div class="cs">Alat yang tersedia di sekolah</div></div><button class="btn bp bsm">+ Tambah</button></div>
            <div class="al alw mb16">⚠️ Hapus alat/bahan jika tidak tersedia di sekolah.</div>
            <div class="fl fw g8">
              <div class="fl ic g8" style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px"><span style="font-size:12px;font-weight:600">Crayon</span><button style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button></div>
              <div class="fl ic g8" style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px"><span style="font-size:12px;font-weight:600">Spidol</span><button style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button></div>
              <div class="fl ic g8" style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px"><span style="font-size:12px;font-weight:600">Pensil</span><button style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button></div>
              <div class="fl ic g8" style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px"><span style="font-size:12px;font-weight:600">Kertas HVS</span><button style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button></div>
              <div class="fl ic g8" style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px"><span style="font-size:12px;font-weight:600">Kertas Origami</span><button style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button></div>
              <div class="fl ic g8" style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px"><span style="font-size:12px;font-weight:600">Gunting</span><button style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button></div>
              <div class="fl ic g8" style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px"><span style="font-size:12px;font-weight:600">Lem</span><button style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button></div>
              <div class="fl ic g8" style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px"><span style="font-size:12px;font-weight:600">Cat Air</span><button style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button></div>
              <div class="fl ic g8" style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px"><span style="font-size:12px;font-weight:600">Kuas</span><button style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button></div>
              <div class="fl ic g8" style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px"><span style="font-size:12px;font-weight:600">LKA</span><button style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button></div>
              <div class="fl ic g8" style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px"><span style="font-size:12px;font-weight:600">Sajadah</span><button style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button></div>
            </div>
          </div>
        </div>
      </div>

      <!-- ===== HALAMAN: VALIDASI RPP ===== -->
      <div class="ca pg" id="vrppm">
        <div class="card">
          <div class="ch"><div class="ct">✅ Validasi RPP</div></div>
          <div class="tabs">
            <button class="tbn on">⏳ Menunggu (3)</button>
            <button class="tbn">✅ Disetujui (8)</button>
            <button class="tbn">↩️ Dikembalikan</button>
          </div>
          <div class="rc2">
            <div class="rh"><div><div class="rw">Mgg ke-1 • Ustadzah Siti Rahmah • Kelas A • 2024/2025</div><div class="rn">Aku, Makhluq Allah</div><div class="rs">Allah Tuhanku</div></div><span class="bdg bpnd">⏳ Pending</span></div>
            <div class="ract"><button class="btn bo bsm">🔍 Detail</button><button class="btn bp bsm">✅ Setujui</button><button class="btn bd bsm">↩️ Kembalikan</button><button class="btn bo bsm">🖨️</button></div>
          </div>
          <div class="rc2">
            <div class="rh"><div><div class="rw">Mgg ke-2 • Ustadzah Dewi Nursanti • Kelas B • 2024/2025</div><div class="rn">Tanah Airku</div><div class="rs">Identitas Negara</div></div><span class="bdg bpnd">⏳ Pending</span></div>
            <div class="ract"><button class="btn bo bsm">🔍 Detail</button><button class="btn bp bsm">✅ Setujui</button><button class="btn bd bsm">↩️ Kembalikan</button><button class="btn bo bsm">🖨️</button></div>
          </div>
          <div class="rc2">
            <div class="rh"><div><div class="rw">Mgg ke-3 • Ustadzah Siti Rahmah • Kelas A • 2024/2025</div><div class="rn">Lingkunganku</div><div class="rs">Rumahku</div></div><span class="bdg bpnd">⏳ Pending</span></div>
            <div class="al ale mt8">📝 Perlu ditambahkan kegiatan aspek Seni</div>
            <div class="ract"><button class="btn bo bsm">🔍 Detail</button><button class="btn bp bsm">✅ Setujui</button><button class="btn bd bsm">↩️ Kembalikan</button><button class="btn bo bsm">🖨️</button></div>
          </div>
        </div>
      </div>

      <!-- ===== HALAMAN: VALIDASI RPPH ===== -->
      <div class="ca pg" id="vrpph">
        <div class="card">
          <div class="ch"><div class="ct">📄 Validasi RPPH</div></div>
          <div class="tabs">
            <button class="tbn on">⏳ Menunggu (2)</button>
            <button class="tbn">✅ Disetujui (10)</button>
          </div>
          <div class="rc2">
            <div class="rh"><div><div class="rw">Senin, 14 Juli 2025 • Kelas A</div><div class="rn">Aku, Makhluq Allah</div><div class="rs">Allah Tuhanku — Aku Bersyukur kepada Allah</div></div><span class="bdg bpnd">⏳ Pending</span></div>
            <div class="ract"><button class="btn bo bsm">🔍 Detail</button><button class="btn bp bsm">✅ Setujui</button><button class="btn bd bsm">↩️</button><button class="btn bo bsm">🖨️</button></div>
          </div>
          <div class="rc2">
            <div class="rh"><div><div class="rw">Selasa, 15 Juli 2025 • Kelas B</div><div class="rn">Tanah Airku</div><div class="rs">Identitas Negara — Bendera Merah Putih</div></div><span class="bdg bpnd">⏳ Pending</span></div>
            <div class="ract"><button class="btn bo bsm">🔍 Detail</button><button class="btn bp bsm">✅ Setujui</button><button class="btn bd bsm">↩️</button><button class="btn bo bsm">🖨️</button></div>
          </div>
        </div>
      </div>

      <!-- ===== HALAMAN: VALIDASI KEGIATAN ===== -->
      <div class="ca pg" id="vkeg">
        <div class="al ali mb16">ℹ️ Kegiatan terkunci setelah digunakan di <strong>3 tahun ajaran berbeda</strong>. Guru perlu mengusulkan kegiatan baru.</div>
        <div class="card mb16">
          <div class="ch"><div class="ct">🕐 Menunggu Validasi (1)</div></div>
          <div class="kc">
            <div class="fl jb ic mb8"><div class="kn">Melukis Masjid Sederhana dengan Cat Air</div><span class="bdg bpnd">⏳ Pending</span></div>
            <div class="kd">Anak melukis gambar masjid menggunakan cat air di atas kertas HVS dengan bimbingan guru.</div>
            <div class="fl fw g8 mb8">
              <span class="ap a1">🕌 Nilai Agama</span>
              <span class="ap a6">🎨 Seni</span>
              <span class="ap a2">🏃 Fisik Motorik</span>
            </div>
            <div class="fs11 tc2 mb8">🎭 Bentuk: Melukis | 🔧 Alat: Cat Air, Kuas, Kertas HVS</div>
            <div class="fs11 tc2 mb8">Diusulkan: Ustadzah Siti Rahmah</div>
            <div class="fl g8 mt8">
              <button class="btn bp bsm">✅ Setujui & Tambah ke Kumpulan</button>
              <button class="btn bd bsm">❌ Tolak</button>
            </div>
          </div>
        </div>
        <div class="card mb16">
          <div class="ch"><div class="ct">🔒 Kegiatan Terkunci (2)</div></div>
          <div class="kc lck">
            <div class="fl jb ic mb8"><div class="kn">🔒 Kolase Tulisan "Terima Kasih Ya Allah"</div><span class="bdg blk">Terkunci</span></div>
            <div class="fs11 tc2 mb4">🎭 Kolase | Tema: Aku, Makhluq Allah</div>
            <div class="fs11" style="color:var(--red)">Dipakai di: 2022/2023 → 2023/2024 → 2024/2025</div>
            <div class="al alw mt8">🔒 Sudah digunakan di <strong>3 tahun ajaran</strong> dan terkunci permanen.</div>
          </div>
          <div class="kc lck mt8">
            <div class="fl jb ic mb8"><div class="kn">🔒 Mewarnai Tulisan "Allah"</div><span class="bdg blk">Terkunci</span></div>
            <div class="fs11 tc2 mb4">🎭 Mewarnai | Tema: Aku, Makhluq Allah</div>
            <div class="fs11" style="color:var(--red)">Dipakai di: 2022/2023 → 2023/2024 → 2024/2025</div>
            <div class="al alw mt8">🔒 Sudah digunakan di <strong>3 tahun ajaran</strong> dan terkunci permanen.</div>
          </div>
        </div>
        <div class="card">
          <div class="ch"><div class="ct">✅ Semua Kumpulan Kegiatan (15)</div></div>
          <div class="tw">
            <table>
              <thead><tr><th>Nama Kegiatan</th><th>Bentuk</th><th>Aspek</th><th>Dipakai di Tahun</th><th>Status</th></tr></thead>
              <tbody>
                <tr><td><strong>Kolase Tulisan "Terima Kasih Ya Allah"</strong></td><td>Kolase</td><td><span class="ap a1">🕌</span> <span class="ap a6">🎨</span></td><td>2022/2023, 2023/2024, 2024/2025<div class="pw mt8"><div class="pb pk" style="width:100%"></div></div><div class="fs11">3/3 — TERKUNCI</div></td><td><span class="bdg blk">🔒 Terkunci</span></td></tr>
                <tr><td><strong>Menebalkan Nama Sendiri</strong></td><td>Menggambar</td><td><span class="ap a3">🧠</span> <span class="ap a4">💬</span></td><td>2023/2024, 2024/2025<div class="pw mt8"><div class="pb or" style="width:66%"></div></div><div class="fs11 tc2">2/3 tahun ajaran</div></td><td><span class="bdg bok">✅</span></td></tr>
                <tr><td><strong>Finger Painting Anggota Tubuh</strong></td><td>Finger Painting</td><td><span class="ap a2">🏃</span> <span class="ap a6">🎨</span></td><td>2023/2024<div class="pw mt8"><div class="pb gr" style="width:33%"></div></div><div class="fs11 tc2">1/3 tahun ajaran</div></td><td><span class="bdg bok">✅</span></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ===== HALAMAN: MONITORING GURU ===== -->
      <div class="ca pg" id="monitoring">
        <div class="card">
          <div class="ch"><div class="ct">📈 Monitoring Semua Guru</div></div>
          <div class="card mb16" style="border-color:var(--g2)">
            <div class="fl ic g12 mb16">
              <div style="width:50px;height:50px;background:var(--g6);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:800;font-size:20px">S</div>
              <div><div class="fw7">Ustadzah Siti Rahmah</div><div class="fs11 tc2">Kelas A • 0812-1111-2222</div></div>
            </div>
            <div class="g3 mb16">
              <div class="ib"><div class="ik">Total RPP</div><div class="iv">6</div></div>
              <div class="ib"><div class="ik">RPP Disetujui</div><div class="iv" style="color:var(--g6)">4</div></div>
              <div class="ib"><div class="ik">Total RPPH</div><div class="iv">18</div></div>
              <div class="ib"><div class="ik">Portofolio</div><div class="iv">24 entri</div></div>
              <div class="ib"><div class="ik">RPP Pending</div><div class="iv" style="color:var(--acc2)">2</div></div>
              <div class="ib"><div class="ik">Progress</div><div class="iv">67%</div></div>
            </div>
            <div class="pw"><div class="pb gr" style="width:67%"></div></div>
          </div>
          <div class="card mb16" style="border-color:var(--g2)">
            <div class="fl ic g12 mb16">
              <div style="width:50px;height:50px;background:var(--g6);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:800;font-size:20px">D</div>
              <div><div class="fw7">Ustadzah Dewi Nursanti</div><div class="fs11 tc2">Kelas B • 0813-3333-4444</div></div>
            </div>
            <div class="g3 mb16">
              <div class="ib"><div class="ik">Total RPP</div><div class="iv">5</div></div>
              <div class="ib"><div class="ik">RPP Disetujui</div><div class="iv" style="color:var(--g6)">4</div></div>
              <div class="ib"><div class="ik">Total RPPH</div><div class="iv">15</div></div>
              <div class="ib"><div class="ik">Portofolio</div><div class="iv">20 entri</div></div>
              <div class="ib"><div class="ik">RPP Pending</div><div class="iv" style="color:var(--acc2)">1</div></div>
              <div class="ib"><div class="ik">Progress</div><div class="iv">80%</div></div>
            </div>
            <div class="pw"><div class="pb gr" style="width:80%"></div></div>
          </div>
        </div>
      </div>

      <!-- ===== HALAMAN: KUMPULAN KEGIATAN (GURU) ===== -->
      <div class="ca pg" id="keg">
        <div class="card mb16">
          <div class="ch">
            <div><div class="ct">🗂️ Kumpulan Kegiatan</div><div class="cs">Terkunci otomatis setelah dipakai di 3 tahun ajaran berbeda.</div></div>
            <button class="btn bp bsm">+ Usulkan Kegiatan Baru</button>
          </div>
          <div class="al ali mb16">ℹ️ <strong>Cara kerja penguncian:</strong> Jika kegiatan <em>sama persis</em> sudah digunakan di <strong>3 tahun ajaran berbeda</strong>, kegiatan terkunci permanen.</div>
          <div class="fb">
            <input type="text" placeholder="🔍 Cari kegiatan..."/>
            <select><option>Semua Tema</option><option>Aku, Makhluq Allah</option><option>Tanah Airku</option></select>
            <select><option>Semua Bentuk</option><option>Mewarnai</option><option>Kolase</option></select>
            <select><option>Semua Status</option><option>✅ Aktif</option><option>🔒 Terkunci</option></select>
          </div>
          <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:12px">
            <div class="kc">
              <div class="fl jb ic mb8"><div class="kn">Menebalkan Nama Sendiri</div><span class="bdg bok">✅</span></div>
              <div class="kd">Anak menebalkan huruf nama sendiri pada lembar kerja yang tersedia guru.</div>
              <div class="fl fw g8 mb8"><span class="ap a3">🧠 Kognitif</span><span class="ap a4">💬 Bahasa</span><span class="ap a2">🏃 Fisik Motorik</span></div>
              <div class="fs11 tc2 mb8">🎭 Menggambar | 🔧 LKA, Pensil</div>
              <div class="fs11 tc2 mb4">📅 Dipakai di: 2023/2024, 2024/2025</div>
              <div class="pw mb4"><div class="pb or" style="width:66%"></div></div>
              <div class="fs11 tc2">2/3 tahun ajaran</div>
            </div>
            <div class="kc lck">
              <div class="fl jb ic mb8"><div class="kn">🔒 Kolase Tulisan "Terima Kasih Ya Allah"</div><span class="bdg blk">Terkunci</span></div>
              <div class="kd">Anak menempel potongan kertas origami pada pola tulisan yang disediakan guru.</div>
              <div class="fl fw g8 mb8"><span class="ap a1">🕌 Nilai Agama</span><span class="ap a6">🎨 Seni</span></div>
              <div class="fs11 tc2 mb8">🎭 Kolase | 🔧 Kertas Origami, Lem, Gunting</div>
              <div class="fs11 tc2 mb4">📅 Dipakai di: 2022/2023, 2023/2024, 2024/2025</div>
              <div class="pw mb4"><div class="pb pk" style="width:100%"></div></div>
              <div class="fs11" style="color:var(--red)">3/3 tahun ajaran — TERKUNCI PERMANEN</div>
              <div class="al ale mt8">🔒 Kegiatan ini sudah terkunci. Anda perlu membuat kegiatan baru.</div>
              <div class="rek-box"><div class="rek-title">💡 Rekomendasi Kegiatan Lain di Tema yang Sama:</div>
                <div class="rek-item"><strong>Finger Painting Anggota Tubuh</strong><br><span class="fs11 tc2">Finger Painting — 1/3 tahun</span></div>
                <div class="rek-item"><strong>Mewarnai Gambar Anggota Tubuh</strong><br><span class="fs11 tc2">Mewarnai — 2/3 tahun</span></div>
              </div>
            </div>
            <div class="kc">
              <div class="fl jb ic mb8"><div class="kn">Finger Painting Anggota Tubuh</div><span class="bdg bok">✅</span></div>
              <div class="kd">Anak membuat jejak tangan dan kaki menggunakan cat air di kertas HVS.</div>
              <div class="fl fw g8 mb8"><span class="ap a2">🏃 Fisik Motorik</span><span class="ap a6">🎨 Seni</span><span class="ap a5">❤️ Sosial Emosional</span></div>
              <div class="fs11 tc2 mb8">🎭 Finger Painting | 🔧 Cat Air, Kertas HVS</div>
              <div class="fs11 tc2 mb4">📅 Dipakai di: 2023/2024</div>
              <div class="pw mb4"><div class="pb gr" style="width:33%"></div></div>
              <div class="fs11 tc2">1/3 tahun ajaran</div>
            </div>
          </div>
        </div>
      </div>

      <!-- ===== HALAMAN: BUAT & KELOLA RPP ===== -->
      <div class="ca pg" id="rppm">
        <div class="tabs">
          <button class="tbn on">📋 Daftar RPP (6)</button>
          <button class="tbn">+ Buat RPP Baru</button>
        </div>
        <!-- Daftar RPP -->
        <div>
          <div class="rc2">
            <div class="rh"><div><div class="rw">Mgg ke-1 — Sem 1 — 2024/2025</div><div class="rn">Aku, Makhluq Allah</div><div class="rs">Allah Tuhanku</div></div><span class="bdg bok">✅ Disetujui</span></div>
            <div class="ract"><button class="btn bo bsm">👁️ Detail</button><button class="btn bp bsm">⚡ Generate RPPH</button><button class="btn bo bsm">🖨️</button></div>
          </div>
          <div class="rc2">
            <div class="rh"><div><div class="rw">Mgg ke-2 — Sem 1 — 2024/2025</div><div class="rn">Tanah Airku</div><div class="rs">Identitas Negara</div></div><span class="bdg bpnd">⏳ Pending</span></div>
            <div class="ract"><button class="btn bo bsm">👁️ Detail</button><button class="btn bo bsm">🖨️</button></div>
          </div>
          <div class="rc2">
            <div class="rh"><div><div class="rw">Mgg ke-3 — Sem 1 — 2024/2025</div><div class="rn">Lingkunganku</div><div class="rs">Rumahku</div></div><span class="bdg bdr">📝 Draft</span></div>
            <div class="al ale mt8">📝 Perlu ditambahkan kegiatan aspek Seni</div>
            <div class="ract"><button class="btn bo bsm">👁️ Detail</button><button class="btn ba bsm">📤 Ajukan ke Kepala</button><button class="btn bo bsm">🖨️</button></div>
          </div>
        </div>
        <!-- Form Buat RPP (tersembunyi, tampil saat tab diklik) -->
        <div style="display:none">
          <div class="card">
            <div class="ch"><div class="ct">📝 Form RPP Baru</div></div>
            <div class="fs11 tc2 mb16" style="text-transform:uppercase;letter-spacing:1px;font-weight:700">A. Identitas</div>
            <div class="fr c3">
              <div class="ff"><label>Tema</label><select><option>-- Pilih --</option><option>Aku, Makhluq Allah</option><option>Tanah Airku</option></select></div>
              <div class="ff"><label>Sub Tema</label><select><option>Pilih tema dulu</option></select></div>
              <div class="ff"><label>Minggu Ke</label><input type="number" min="1" max="17" placeholder="1-17"/></div>
            </div>
            <div class="fr c2">
              <div class="ff"><label>Model Pembelajaran</label><select><option>Berbasis Proyek</option><option>Kelompok dengan Sudut</option><option>Sentra</option><option>Area</option><option>STEM</option></select></div>
              <div class="ff"><label>Tahun Ajaran</label><input value="2024/2025" disabled/></div>
            </div>
            <div class="fr"><div class="ff"><label>Tujuan Pembelajaran</label><textarea rows="2" placeholder="Tujuan pembelajaran minggu ini..."></textarea></div></div>
            <div class="fr"><div class="ff"><label>Capaian Pembelajaran</label><textarea rows="2" placeholder="Capaian yang diharapkan..."></textarea></div></div>
            <div class="dv"></div>
            <div class="fs11 tc2 mb16" style="text-transform:uppercase;letter-spacing:1px;font-weight:700">B. Kegiatan Per Hari</div>
            <div class="al alw mb16">⚠️ Aspek belum terstimulasi: <strong>🎨 Seni</strong>, <strong>❤️ Sosial Emosional</strong></div>
            <div class="dt">
              <div class="dtb on">Senin (2)</div>
              <div class="dtb fl">Selasa (1)</div>
              <div class="dtb">Rabu (0)</div>
              <div class="dtb fl">Kamis (2)</div>
              <div class="dtb">Jumat (0)</div>
            </div>
            <div class="ds">
              <div class="dsh"><span class="dn">📅 Senin</span><button class="btn bp bxs">+ Pilih Kegiatan</button></div>
              <div class="dki"><div><strong>Menebalkan Nama Sendiri</strong> <span class="fs11 tc2">(Menggambar)</span><div class="mt8"><span class="ap a3">🧠 Kognitif</span> <span class="ap a4">💬 Bahasa</span></div></div><button class="btn bd bxs">✕</button></div>
              <div class="dki"><div><strong>Finger Painting Anggota Tubuh</strong> <span class="fs11 tc2">(Finger Painting)</span><div class="mt8"><span class="ap a2">🏃 Fisik Motorik</span> <span class="ap a6">🎨 Seni</span></div></div><button class="btn bd bxs">✕</button></div>
            </div>
            <div class="dv"></div>
            <div class="fs11 tc2 mb16" style="text-transform:uppercase;letter-spacing:1px;font-weight:700">C. Analisis Aspek Real-time</div>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:10px">
              <div class="card" style="padding:12px"><div class="fl jb ic mb8"><span class="ap a1">🕌 Nilai Agama</span><strong style="font-size:18px;color:var(--g6)">2</strong></div><div class="pw"><div class="pb gr" style="width:80%"></div></div></div>
              <div class="card" style="padding:12px"><div class="fl jb ic mb8"><span class="ap a2">🏃 Fisik Motorik</span><strong style="font-size:18px;color:var(--g6)">3</strong></div><div class="pw"><div class="pb bl" style="width:100%"></div></div></div>
              <div class="card" style="padding:12px"><div class="fl jb ic mb8"><span class="ap a3">🧠 Kognitif</span><strong style="font-size:18px;color:var(--g6)">2</strong></div><div class="pw"><div class="pb ye" style="width:60%"></div></div></div>
              <div class="card" style="padding:12px"><div class="fl jb ic mb8"><span class="ap a4">💬 Bahasa</span><strong style="font-size:18px;color:var(--g6)">1</strong></div><div class="pw"><div class="pb gr" style="width:40%"></div></div></div>
              <div class="card" style="padding:12px;border-color:#fecaca"><div class="fl jb ic mb8"><span class="ap a5">❤️ Sosial Emosional</span><strong style="font-size:18px;color:var(--red)">0</strong></div><div class="pw"><div class="pb pk" style="width:0%"></div></div><div class="fs11 mt8" style="color:var(--red)">⚠️ Belum ada</div></div>
              <div class="card" style="padding:12px;border-color:#fecaca"><div class="fl jb ic mb8"><span class="ap a6">🎨 Seni</span><strong style="font-size:18px;color:var(--red)">0</strong></div><div class="pw"><div class="pb or" style="width:0%"></div></div><div class="fs11 mt8" style="color:var(--red)">⚠️ Belum ada</div></div>
            </div>
            <div class="dv"></div>
            <div class="fl jb g12">
              <button class="btn bo">🔄 Reset</button>
              <div class="fl g12">
                <button class="btn bo">💾 Simpan Draft</button>
                <button class="btn ba">📤 Ajukan ke Kepala Sekolah</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ===== HALAMAN: BUAT & KELOLA RPPH ===== -->
      <div class="ca pg" id="rpph">
        <div class="card mb16">
          <div class="ch"><div class="ct">📄 RPPH dari RPP Disetujui</div></div>
          <div class="rc2">
            <div class="rh"><div><div class="rw">Mgg ke-1 • 2024/2025</div><div class="rn">Aku, Makhluq Allah</div><div class="rs">Allah Tuhanku</div></div><span class="bdg bok">✅ RPP Disetujui</span></div>
            <div class="fl fw g8 mt8 mb8">
              <div style="padding:6px 12px;background:var(--g1);border:2px solid var(--g4);border-radius:7px;font-size:11.5px;font-weight:700">Senin ✅</div>
              <div style="padding:6px 12px;background:#eff6ff;border:2px solid #bfdbfe;border-radius:7px;font-size:11.5px;font-weight:700">Selasa 📝</div>
              <div style="padding:6px 12px;background:var(--g0);border:2px solid var(--g1);border-radius:7px;font-size:11.5px;font-weight:700">Rabu ⚪</div>
              <div style="padding:6px 12px;background:var(--g1);border:2px solid var(--g4);border-radius:7px;font-size:11.5px;font-weight:700">Kamis ✅</div>
              <div style="padding:6px 12px;background:var(--g0);border:2px solid var(--g1);border-radius:7px;font-size:11.5px;font-weight:700">Jumat ⚪</div>
            </div>
            <div class="ract"><button class="btn bp bsm">⚡ Generate/Refresh RPPH</button><button class="btn bo bsm">🖨️ RPP</button></div>
            <div class="ds mt8">
              <div class="dsh"><span class="dn">📅 Senin</span><div class="fl g8"><button class="btn bp bxs">✏️ Edit</button><button class="btn bo bxs">🖨️</button></div></div>
              <div class="dki"><strong>Kolase Tulisan "Terima Kasih Ya Allah"</strong> <span class="fs11 tc2">(Kolase)</span></div>
              <div class="al als mt8">✅ Disetujui Kepala Sekolah</div>
            </div>
            <div class="ds mt8">
              <div class="dsh"><span class="dn">📅 Selasa</span><div class="fl g8"><button class="btn bp bxs">✏️ Edit</button><button class="btn bo bxs">🖨️</button><button class="btn ba bxs">📤</button></div></div>
              <div class="dki"><strong>Menebalkan Nama Sendiri</strong> <span class="fs11 tc2">(Menggambar)</span></div>
              <div class="al ali mt8">📝 Sudah diisi — klik 📤 untuk ajukan ke Kepala</div>
            </div>
          </div>
        </div>
      </div>

      <!-- ===== HALAMAN: PORTOFOLIO SISWA ===== -->
      <div class="ca pg" id="porto">
        <div class="card mb16">
          <div class="ch"><div><div class="ct">📸 Portofolio Siswa Kelas A</div></div><button class="btn bp bsm">+ Input Portofolio</button></div>
          <div class="tabs">
            <button class="tbn on">Zaid</button>
            <button class="tbn">Aisyah</button>
            <button class="tbn">Ibrahim</button>
          </div>
          <div class="g4 mt16">
            <div class="pfc">
              <div class="pfp" style="background:linear-gradient(135deg,var(--g1),var(--g2))">🎨</div>
              <div class="pfb">
                <div class="pfn">Zaid Al-Fatih</div>
                <div class="pfd">📅 14/07/2025 — Kolase Tulisan</div>
                <div class="pfnt">Anak sangat antusias menempel potongan kertas. Motorik halus berkembang baik...</div>
                <div class="fl fw g8 mt8"><span class="ap a1">🕌</span><span class="ap a6">🎨</span><span class="ap a2">🏃</span></div>
                <div class="fs11 tc2 mt8">💬 2 komentar</div>
              </div>
            </div>
            <div class="pfc">
              <div class="pfp" style="background:linear-gradient(135deg,var(--g1),var(--g2))">✏️</div>
              <div class="pfb">
                <div class="pfn">Zaid Al-Fatih</div>
                <div class="pfd">📅 15/07/2025 — Menebalkan Nama</div>
                <div class="pfnt">Zaid sudah bisa menebalkan huruf namanya sendiri dengan rapi dan percaya diri...</div>
                <div class="fl fw g8 mt8"><span class="ap a3">🧠</span><span class="ap a4">💬</span></div>
              </div>
            </div>
            <div class="pfc">
              <div class="pfp" style="background:linear-gradient(135deg,var(--g1),var(--g2))">🏃</div>
              <div class="pfb">
                <div class="pfn">Zaid Al-Fatih</div>
                <div class="pfd">📅 16/07/2025 — Senam Pagi</div>
                <div class="pfnt">Aktif mengikuti gerakan senam, semangat dan ceria bersama teman-teman kelasnya...</div>
                <div class="fl fw g8 mt8"><span class="ap a2">🏃</span><span class="ap a5">❤️</span></div>
                <div class="fs11 tc2 mt8">💬 1 komentar</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ===== HALAMAN: ANALISIS ASPEK ===== -->
      <div class="ca pg" id="analisis">
        <div class="card mb16">
          <div class="ch"><div><div class="ct">📊 Distribusi Aspek — Kelas A</div><div class="cs">Dari 4 RPP disetujui — 32 slot kegiatan</div></div></div>
          <div class="graf-bar"><div class="graf-label"><span class="ap a1">🕌 Nilai Agama</span></div><div class="graf-wrap"><div class="graf-fill pb gr" style="width:28%"><span class="graf-val">9</span></div></div><div class="graf-pct">28%</div></div>
          <div class="graf-bar"><div class="graf-label"><span class="ap a2">🏃 Fisik Motorik</span></div><div class="graf-wrap"><div class="graf-fill pb bl" style="width:22%"><span class="graf-val">7</span></div></div><div class="graf-pct">22%</div></div>
          <div class="graf-bar"><div class="graf-label"><span class="ap a3">🧠 Kognitif</span></div><div class="graf-wrap"><div class="graf-fill pb ye" style="width:19%"><span class="graf-val">6</span></div></div><div class="graf-pct">19%</div></div>
          <div class="graf-bar"><div class="graf-label"><span class="ap a4">💬 Bahasa</span></div><div class="graf-wrap"><div class="graf-fill pb gr" style="width:16%"><span class="graf-val">5</span></div></div><div class="graf-pct">16%</div></div>
          <div class="graf-bar"><div class="graf-label"><span class="ap a5">❤️ Sosial Emosional</span></div><div class="graf-wrap"><div class="graf-fill pb pk" style="width:9%"><span class="graf-val">3</span></div></div><div class="graf-pct">9%</div></div>
          <div class="graf-bar"><div class="graf-label"><span class="ap a6">🎨 Seni</span></div><div class="graf-wrap"><div class="graf-fill pb or" style="width:6%"><span class="graf-val">2</span></div></div><div class="graf-pct">6%</div></div>
        </div>
        <div class="card">
          <div class="ch"><div class="ct">💡 Rekomendasi Keseimbangan</div></div>
          <div class="fl ic g12 mb12"><span class="ap a1" style="min-width:165px;flex-shrink:0">🕌 Nilai Agama</span><span class="fs11" style="color:var(--g6)">✅ Sangat baik!</span></div>
          <div class="fl ic g12 mb12"><span class="ap a2" style="min-width:165px;flex-shrink:0">🏃 Fisik Motorik</span><span class="fs11" style="color:var(--g5)">👍 Cukup seimbang.</span></div>
          <div class="fl ic g12 mb12"><span class="ap a3" style="min-width:165px;flex-shrink:0">🧠 Kognitif</span><span class="fs11" style="color:var(--g5)">👍 Cukup seimbang.</span></div>
          <div class="fl ic g12 mb12"><span class="ap a4" style="min-width:165px;flex-shrink:0">💬 Bahasa</span><span class="fs11" style="color:var(--g5)">👍 Cukup seimbang.</span></div>
          <div class="fl ic g12 mb12"><span class="ap a5" style="min-width:165px;flex-shrink:0">❤️ Sosial Emosional</span><span class="fs11" style="color:var(--acc2)">📌 Perlu ditingkatkan.</span></div>
          <div class="fl ic g12 mb12"><span class="ap a6" style="min-width:165px;flex-shrink:0">🎨 Seni</span><span class="fs11" style="color:var(--acc2)">📌 Perlu ditingkatkan.</span></div>
        </div>
      </div>

      <!-- ===== HALAMAN: ORANG TUA — BERANDA ===== -->
      <div class="ca pg" id="ortu-beranda" style="display:none">
        <div style="background:linear-gradient(135deg,var(--g7),var(--g5));border-radius:var(--r);padding:24px;color:var(--white);margin-bottom:18px;display:flex;align-items:center;gap:16px">
          <div style="width:64px;height:64px;border-radius:50%;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:28px;flex-shrink:0">👨‍👩‍👧</div>
          <div><h2 style="font-size:20px;font-weight:800">Halo, Bapak Ahmad Yusuf!</h2><p style="opacity:.75;margin-top:3px">Pantau perkembangan anak Anda di PAUDQu AL-AULIA</p></div>
        </div>
        <div class="card mb16">
          <div class="fl ic g12 mb16">
            <div style="width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,var(--g4),var(--g3));display:flex;align-items:center;justify-content:center;font-size:26px">👦</div>
            <div><h3 style="font-size:17px;font-weight:800">Zaid Al-Fatih</h3><p class="fs11 tc2">Kelas A • Laki-laki</p></div>
          </div>
          <div class="g3">
            <div class="ib"><div class="ik">Portofolio</div><div class="iv">8 Entri</div></div>
            <div class="ib"><div class="ik">RPP Aktif</div><div class="iv">4</div></div>
            <div class="ib"><div class="ik">Komentar Saya</div><div class="iv">3</div></div>
          </div>
          <div class="fl g8 mt16">
            <button class="btn bp bsm">📸 Lihat Portofolio</button>
            <button class="btn bo bsm">🖨️ Cetak Laporan</button>
          </div>
        </div>
      </div>

      <!-- ===== HALAMAN: ORANG TUA — LIHAT RPP ===== -->
      <div class="ca pg" id="ortu-rppm">
        <div class="card">
          <div class="ch"><div class="ct">📝 RPP Kelas Anak</div><div class="cs">Hanya RPP yang telah disetujui Kepala Sekolah</div></div>
          <div class="rc2">
            <div class="rh"><div><div class="rw">Mgg ke-1 • Kelas A • 2024/2025</div><div class="rn">Aku, Makhluq Allah</div><div class="rs">Allah Tuhanku</div></div><span class="bdg bok">✅ Disetujui</span></div>
            <div class="ig mt8">
              <div class="ib"><div class="ik">Model</div><div class="iv">Berbasis Proyek</div></div>
              <div class="ib"><div class="ik">Tujuan</div><div class="iv" style="font-size:11.5px">Anak dapat mengenal Allah sebagai Tuhan melalui kegiatan kreatif...</div></div>
            </div>
            <div class="ract"><button class="btn bo bsm">👁️ Lihat Detail</button><button class="btn bo bsm">🖨️ Cetak</button></div>
          </div>
          <div class="rc2">
            <div class="rh"><div><div class="rw">Mgg ke-4 • Kelas A • 2024/2025</div><div class="rn">Lingkunganku</div><div class="rs">Sekolahku</div></div><span class="bdg bok">✅ Disetujui</span></div>
            <div class="ig mt8">
              <div class="ib"><div class="ik">Model</div><div class="iv">Kelompok dengan Sudut</div></div>
              <div class="ib"><div class="ik">Tujuan</div><div class="iv" style="font-size:11.5px">Anak mengenal lingkungan sekolah dan merasa nyaman belajar...</div></div>
            </div>
            <div class="ract"><button class="btn bo bsm">👁️ Lihat Detail</button><button class="btn bo bsm">🖨️ Cetak</button></div>
          </div>
        </div>
      </div>

      <!-- ===== HALAMAN: ORANG TUA — LIHAT RPPH ===== -->
      <div class="ca pg" id="ortu-rpph">
        <div class="card">
          <div class="ch"><div class="ct">📄 RPPH Kelas Anak</div><div class="cs">Hanya RPPH yang telah disetujui</div></div>
          <div class="rc2">
            <div class="rh"><div><div class="rw">Senin, 14 Juli 2025 • Kelas A</div><div class="rn">Aku, Makhluq Allah</div><div class="rs">Allah Tuhanku — Aku Bersyukur kepada Allah</div></div><span class="bdg bok">✅</span></div>
            <div class="ract"><button class="btn bo bsm">👁️ Detail</button><button class="btn bo bsm">🖨️</button></div>
          </div>
          <div class="rc2">
            <div class="rh"><div><div class="rw">Selasa, 15 Juli 2025 • Kelas A</div><div class="rn">Aku, Makhluq Allah</div><div class="rs">Identitasku — Mengenal Huruf Namaku</div></div><span class="bdg bok">✅</span></div>
            <div class="ract"><button class="btn bo bsm">👁️ Detail</button><button class="btn bo bsm">🖨️</button></div>
          </div>
        </div>
      </div>

      <!-- ===== HALAMAN: ORANG TUA — PORTOFOLIO ANAK ===== -->
      <div class="ca pg" id="ortu-porto">
        <div class="card">
          <div class="ch"><div><div class="ct">📸 Portofolio Anak</div><div class="cs">Klik foto untuk lihat detail & komentar</div></div></div>
          <div class="fl ic g12 mb16">
            <div style="width:50px;height:50px;border-radius:50%;background:linear-gradient(135deg,var(--g4),var(--g3));display:flex;align-items:center;justify-content:center;font-size:22px">👦</div>
            <div><h3 style="font-size:16px;font-weight:800">Zaid Al-Fatih</h3><p class="fs11 tc2">Kelas A — 8 entri portofolio</p></div>
            <button class="btn bp bsm" style="margin-left:auto">🖨️ Cetak Laporan</button>
          </div>
          <div class="card mb16" style="border-color:var(--g2)">
            <div class="fw7 fs11 mb12">📊 Grafik Aspek Perkembangan Zaid</div>
            <div class="graf-bar"><div class="graf-label"><span class="ap a1">🕌 Nilai Agama</span></div><div class="graf-wrap"><div class="graf-fill pb gr" style="width:37%"><span class="graf-val">3</span></div></div><div class="graf-pct">37%</div></div>
            <div class="graf-bar"><div class="graf-label"><span class="ap a2">🏃 Fisik Motorik</span></div><div class="graf-wrap"><div class="graf-fill pb bl" style="width:25%"><span class="graf-val">2</span></div></div><div class="graf-pct">25%</div></div>
            <div class="graf-bar"><div class="graf-label"><span class="ap a3">🧠 Kognitif</span></div><div class="graf-wrap"><div class="graf-fill pb ye" style="width:25%"><span class="graf-val">2</span></div></div><div class="graf-pct">25%</div></div>
            <div class="graf-bar"><div class="graf-label"><span class="ap a6">🎨 Seni</span></div><div class="graf-wrap"><div class="graf-fill pb or" style="width:12%"><span class="graf-val">1</span></div></div><div class="graf-pct">12%</div></div>
          </div>
          <div class="g4">
            <div class="pfc">
              <div class="pfp" style="background:linear-gradient(135deg,var(--g1),var(--g2))">🎨</div>
              <div class="pfb">
                <div class="pfd">📅 14/07/2025</div>
                <div class="pfn fs11 mt4">Kolase Tulisan</div>
                <div class="pfnt">Anak sangat antusias menempel potongan kertas dengan rapi...</div>
                <div class="fl fw g8 mt8"><span class="ap a1">🕌</span><span class="ap a6">🎨</span></div>
                <div class="fs11 tc2 mt8">💬 2 komentar</div>
              </div>
            </div>
            <div class="pfc">
              <div class="pfp" style="background:linear-gradient(135deg,var(--g1),var(--g2))">✏️</div>
              <div class="pfb">
                <div class="pfd">📅 15/07/2025</div>
                <div class="pfn fs11 mt4">Menebalkan Nama</div>
                <div class="pfnt">Zaid sudah bisa menebalkan huruf namanya sendiri dengan rapi...</div>
                <div class="fl fw g8 mt8"><span class="ap a3">🧠</span><span class="ap a4">💬</span></div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </main>
  </div>
</div>

<!-- ===================== MODALS ===================== -->
<!-- Modal User -->
<div class="mo" id="mUser"><div class="md mmd">
  <div class="mh"><div><div class="mt2">Tambah Pengguna</div></div><button class="mc">✕</button></div>
  <div class="mb">
    <div class="fr c2">
      <div class="ff"><label>Nama Lengkap</label><input placeholder="Nama lengkap"/></div>
      <div class="ff"><label>Username</label><input placeholder="username"/></div>
    </div>
    <div class="fr c2">
      <div class="ff"><label>Password</label><input type="password" placeholder="Password"/></div>
      <div class="ff"><label>Role</label><select><option value="guru">Guru</option><option value="ortu">Orang Tua</option></select></div>
    </div>
    <div class="fr c2">
      <div class="ff"><label>Kelas</label><select><option value="A">Kelas A</option><option value="B">Kelas B</option></select></div>
      <div class="ff"><label>No. HP</label><input placeholder="08xx"/></div>
    </div>
  </div>
  <div class="mf"><button class="btn bo">Batal</button><button class="btn bp">💾 Simpan</button></div>
</div></div>

<!-- Modal Siswa -->
<div class="mo" id="mSiswa"><div class="md mmd">
  <div class="mh"><div><div class="mt2">Tambah Siswa</div></div><button class="mc">✕</button></div>
  <div class="mb">
    <div class="fr c2">
      <div class="ff"><label>Nama Siswa</label><input placeholder="Nama lengkap"/></div>
      <div class="ff"><label>Kelas</label><select><option value="A">Kelas A</option><option value="B">Kelas B</option></select></div>
    </div>
    <div class="fr c2">
      <div class="ff"><label>Tanggal Lahir</label><input type="date"/></div>
      <div class="ff"><label>Jenis Kelamin</label><select><option value="L">Laki-laki</option><option value="P">Perempuan</option></select></div>
    </div>
  </div>
  <div class="mf"><button class="btn bo">Batal</button><button class="btn bp">💾 Simpan</button></div>
</div></div>

<!-- Modal Tema -->
<div class="mo" id="mTema"><div class="md mmd">
  <div class="mh"><div><div class="mt2">Tambah Tema</div></div><button class="mc">✕</button></div>
  <div class="mb">
    <div class="fr c2">
      <div class="ff"><label>Nama Tema</label><input placeholder="Nama tema..."/></div>
      <div class="ff"><label>Semester</label><select><option value="1">Semester 1</option><option value="2">Semester 2</option></select></div>
    </div>
    <div class="ff mb16"><label>Sub Tema (satu per baris)</label><textarea rows="5" placeholder="Sub Tema 1&#10;Sub Tema 2"></textarea></div>
  </div>
  <div class="mf"><button class="btn bo">Batal</button><button class="btn bp">💾 Simpan</button></div>
</div></div>

<!-- Modal Bentuk Kegiatan -->
<div class="mo" id="mBentuk"><div class="md msm">
  <div class="mh"><div><div class="mt2">Tambah Bentuk Kegiatan</div></div><button class="mc">✕</button></div>
  <div class="mb"><div class="ff"><label>Nama Bentuk Kegiatan</label><input placeholder="Contoh: Mewarnai, Kolase..."/></div></div>
  <div class="mf"><button class="btn bo">Batal</button><button class="btn bp">💾 Simpan</button></div>
</div></div>

<!-- Modal Alat Bahan -->
<div class="mo" id="mAlat"><div class="md msm">
  <div class="mh"><div><div class="mt2">Tambah Alat & Bahan</div></div><button class="mc">✕</button></div>
  <div class="mb"><div class="ff"><label>Nama Alat / Bahan</label><input placeholder="Contoh: Crayon, HVS..."/></div></div>
  <div class="mf"><button class="btn bo">Batal</button><button class="btn bp">💾 Simpan</button></div>
</div></div>

<!-- Modal Usul Kegiatan -->
<div class="mo" id="mKeg"><div class="md mlg">
  <div class="mh"><div><div class="mt2">Usulkan Kegiatan Baru</div><div class="mst">Akan divalidasi Kepala Sekolah</div></div><button class="mc">✕</button></div>
  <div class="mb">
    <div class="fr c2">
      <div class="ff"><label>Nama Kegiatan (Spesifik)</label><input placeholder="Contoh: Mewarnai Kaligrafi Allah"/></div>
      <div class="ff"><label>Tema</label><select><option value="">-- Pilih Tema --</option><option>Aku, Makhluq Allah</option><option>Tanah Airku</option></select></div>
    </div>
    <div class="fr c2">
      <div class="ff"><label>Bentuk Kegiatan</label><select><option value="">-- Pilih --</option><option>Mewarnai</option><option>Kolase</option><option>Menggambar</option></select></div>
      <div class="ff"><label>Sub Tema</label><input placeholder="Sub tema terkait..."/></div>
    </div>
    <div class="ff mb16"><label>Deskripsi / Langkah Kegiatan</label><textarea rows="4" placeholder="Jelaskan langkah-langkah kegiatan..."></textarea></div>
    <div class="ff mb16">
      <label>Alat & Bahan (centang yang digunakan)</label>
      <div class="cbg">
        <label class="cbi"><input type="checkbox"> Crayon</label>
        <label class="cbi"><input type="checkbox"> Gunting</label>
        <label class="cbi"><input type="checkbox"> Lem</label>
        <label class="cbi"><input type="checkbox"> Kertas HVS</label>
        <label class="cbi"><input type="checkbox"> Cat Air</label>
        <label class="cbi"><input type="checkbox"> LKA</label>
      </div>
    </div>
    <div class="ff mb16">
      <label>Aspek Perkembangan</label>
      <div class="cbg">
        <label class="cbi"><input type="checkbox" value="1"> 🕌 Nilai Agama & Moral</label>
        <label class="cbi"><input type="checkbox" value="2"> 🏃 Fisik Motorik</label>
        <label class="cbi"><input type="checkbox" value="3"> 🧠 Kognitif</label>
        <label class="cbi"><input type="checkbox" value="4"> 💬 Bahasa</label>
        <label class="cbi"><input type="checkbox" value="5"> ❤️ Sosial Emosional</label>
        <label class="cbi"><input type="checkbox" value="6"> 🎨 Seni</label>
      </div>
    </div>
  </div>
  <div class="mf"><button class="btn bo">Batal</button><button class="btn bp">📤 Usulkan</button></div>
</div></div>

<!-- Modal Kembalikan -->
<div class="mo" id="mKmb"><div class="md msm">
  <div class="mh"><div><div class="mt2">↩️ Kembalikan</div><div class="mst">Berikan catatan perbaikan</div></div><button class="mc">✕</button></div>
  <div class="mb"><div class="ff"><label>Catatan Perbaikan</label><textarea rows="5" placeholder="Tuliskan catatan..."></textarea></div></div>
  <div class="mf"><button class="btn bo">Batal</button><button class="btn bd">↩️ Kembalikan</button></div>
</div></div>

<!-- Modal Detail RPP -->
<div class="mo" id="mDRPP"><div class="md mxl">
  <div class="mh"><div><div class="mt2">📋 Detail RPP</div><div class="mst">Aku, Makhluq Allah — Allah Tuhanku | Ustadzah Siti Rahmah</div></div><button class="mc">✕</button></div>
  <div class="mb">
    <div class="ig mb16">
      <div class="ib"><div class="ik">Guru</div><div class="iv">Ustadzah Siti Rahmah</div></div>
      <div class="ib"><div class="ik">Kelas</div><div class="iv">A</div></div>
      <div class="ib"><div class="ik">Tema</div><div class="iv">Aku, Makhluq Allah</div></div>
      <div class="ib"><div class="ik">Sub Tema</div><div class="iv">Allah Tuhanku</div></div>
      <div class="ib"><div class="ik">Minggu Ke</div><div class="iv">1</div></div>
      <div class="ib"><div class="ik">Model</div><div class="iv">Berbasis Proyek</div></div>
    </div>
    <div class="al ali mb8"><strong>Tujuan:</strong> Anak dapat mengenal Allah sebagai Tuhan melalui kegiatan kreatif yang menyenangkan.</div>
    <div class="al als mb16"><strong>Capaian:</strong> Anak mampu menyebut nama Allah, menempel kolase, dan memahami ciptaan Allah.</div>
    <h4 style="font-size:13px;margin-bottom:10px">📅 Jadwal Kegiatan</h4>
    <div class="ds"><div class="dsh"><span class="dn">📅 Senin</span></div>
      <div class="dki"><div><strong>Kolase Tulisan "Terima Kasih Ya Allah"</strong> <span class="fs11 tc2">(Kolase)</span><div class="mt8"><span class="ap a1">🕌 Nilai Agama</span> <span class="ap a6">🎨 Seni</span></div></div></div>
    </div>
    <div class="ds"><div class="dsh"><span class="dn">📅 Selasa</span></div>
      <div class="dki"><div><strong>Menebalkan Nama Sendiri</strong> <span class="fs11 tc2">(Menggambar)</span><div class="mt8"><span class="ap a3">🧠 Kognitif</span> <span class="ap a4">💬 Bahasa</span></div></div></div>
    </div>
  </div>
  <div class="mf">
    <button class="btn bo">Tutup</button>
    <button class="btn bp">✅ Setujui</button>
    <button class="btn bd">↩️ Kembalikan</button>
    <button class="btn bo">🖨️ Cetak</button>
  </div>
</div></div>

<!-- Modal Edit RPPH -->
<div class="mo" id="mERP"><div class="md mlg">
  <div class="mh"><div><div class="mt2">✏️ Edit RPPH</div><div class="mst">Senin — Aku, Makhluq Allah | Allah Tuhanku</div></div><button class="mc">✕</button></div>
  <div class="mb">
    <div class="ig mb16">
      <div class="ib"><div class="ik">Hari</div><div class="iv">Senin</div></div>
      <div class="ib"><div class="ik">Kelas</div><div class="iv">A</div></div>
      <div class="ib"><div class="ik">Tema</div><div class="iv">Aku, Makhluq Allah</div></div>
      <div class="ib"><div class="ik">Sub Tema</div><div class="iv">Allah Tuhanku</div></div>
    </div>
    <div class="fr c2">
      <div class="ff"><label>Tanggal</label><input placeholder="Contoh: 14 Juli 2025"/></div>
      <div class="ff"><label>Sub-Sub Tema (Topik Hari Ini)</label><input placeholder="Contoh: Aku Bersyukur kepada Allah"/></div>
    </div>
    <div style="background:var(--g0);border-radius:var(--r2);padding:13px;margin-bottom:14px">
      <strong class="fs11">📋 KEGIATAN (dari kumpulan):</strong>
      <div style="margin-top:9px;padding:9px;background:var(--white);border-left:3px solid var(--g4);border-radius:4px">
        <strong>Kolase Tulisan "Terima Kasih Ya Allah"</strong> <span class="fs11 tc2">(Kolase)</span><br>
        <span class="fs11 tc2">Anak menempel potongan kertas origami pada pola tulisan yang disediakan guru</span><br>
        <span class="fs11">🔧 Alat: Kertas Origami, Lem, Gunting</span>
      </div>
    </div>
    <div class="ff mb16"><label>A. Kegiatan Pembuka</label><textarea rows="3" placeholder="Contoh: Salam, doa, absen, tepuk semangat..."></textarea></div>
    <div class="ff mb16"><label>B. Langkah-langkah Kegiatan Inti</label><textarea rows="6" placeholder="Jelaskan langkah kegiatan inti..."></textarea></div>
    <div class="ff"><label>C. Kegiatan Penutup / Recalling</label><textarea rows="3" placeholder="Contoh: Tanya jawab, doa penutup..."></textarea></div>
  </div>
  <div class="mf"><button class="btn bo">Batal</button><button class="btn bp">💾 Simpan RPPH</button></div>
</div></div>

<!-- Modal Porto Input -->
<div class="mo" id="mPrt"><div class="md mlg">
  <div class="mh"><div><div class="mt2">📸 Input Portofolio</div></div><button class="mc">✕</button></div>
  <div class="mb">
    <div class="fr c2">
      <div class="ff"><label>Nama Siswa</label><select><option>Zaid Al-Fatih</option><option>Aisyah Nur Fadilah</option></select></div>
      <div class="ff"><label>Tanggal</label><input type="date"/></div>
    </div>
    <div class="ff mb16"><label>Nama Kegiatan</label><input placeholder="Nama kegiatan hari ini..."/></div>
    <div class="ff mb16"><label>Catatan Perkembangan</label><textarea rows="4" placeholder="Tuliskan pengamatan perkembangan anak..."></textarea></div>
    <div class="ff mb16">
      <label>Aspek yang Dicapai</label>
      <div class="cbg">
        <label class="cbi"><input type="checkbox"> 🕌 Nilai Agama & Moral</label>
        <label class="cbi"><input type="checkbox"> 🏃 Fisik Motorik</label>
        <label class="cbi"><input type="checkbox"> 🧠 Kognitif</label>
        <label class="cbi"><input type="checkbox"> 💬 Bahasa</label>
        <label class="cbi"><input type="checkbox"> ❤️ Sosial Emosional</label>
        <label class="cbi"><input type="checkbox"> 🎨 Seni</label>
      </div>
    </div>
    <div class="ff">
      <label>Foto Kegiatan (Pilih Ikon)</label>
      <div style="display:flex;flex-wrap:wrap;gap:7px;margin-top:6px">
        <div style="width:46px;height:46px;border-radius:9px;border:2px solid var(--g2);display:flex;align-items:center;justify-content:center;font-size:22px;cursor:pointer">🎨</div>
        <div style="width:46px;height:46px;border-radius:9px;border:2px solid var(--g2);display:flex;align-items:center;justify-content:center;font-size:22px;cursor:pointer">📸</div>
        <div style="width:46px;height:46px;border-radius:9px;border:2px solid var(--g2);display:flex;align-items:center;justify-content:center;font-size:22px;cursor:pointer">✏️</div>
        <div style="width:46px;height:46px;border-radius:9px;border:2px solid var(--g2);display:flex;align-items:center;justify-content:center;font-size:22px;cursor:pointer">🧩</div>
        <div style="width:46px;height:46px;border-radius:9px;border:2px solid var(--g2);display:flex;align-items:center;justify-content:center;font-size:22px;cursor:pointer">📚</div>
        <div style="width:46px;height:46px;border-radius:9px;border:2px solid var(--g2);display:flex;align-items:center;justify-content:center;font-size:22px;cursor:pointer">🌱</div>
        <div style="width:46px;height:46px;border-radius:9px;border:2px solid var(--g2);display:flex;align-items:center;justify-content:center;font-size:22px;cursor:pointer">🕌</div>
        <div style="width:46px;height:46px;border-radius:9px;border:2px solid var(--g2);display:flex;align-items:center;justify-content:center;font-size:22px;cursor:pointer">🏃</div>
      </div>
    </div>
  </div>
  <div class="mf"><button class="btn bo">Batal</button><button class="btn bp">💾 Simpan</button></div>
</div></div>

<!-- Modal Cetak RPP -->
<div class="mo" id="mCRP"><div class="md mxl">
  <div class="mh"><div><div class="mt2">🖨️ Preview Cetak RPP</div></div><button class="mc">✕</button></div>
  <div class="mb">
    <div class="pra">
      <div style="text-align:center;border-bottom:3px double #000;padding-bottom:10px;margin-bottom:14px">
        <div style="font-size:14px;font-weight:bold;text-transform:uppercase">PAUDQu AL-AULIA</div>
        <div style="font-size:11px">NPSN: 69990123 | Jl. Al-Quran No.12, Serang, Banten</div>
        <div style="font-size:16px;font-weight:bold;margin-top:7px;text-transform:uppercase">RENCANA PELAKSANAAN PEMBELAJARAN MINGGUAN (RPP)</div>
        <div>Tahun Ajaran 2024/2025 — Semester 1</div>
      </div>
      <table class="prt" style="margin-bottom:14px">
        <tr><td style="width:22%;font-weight:bold">Satuan PAUD</td><td>PAUDQu AL-AULIA</td><td style="width:22%;font-weight:bold">Semester/Minggu</td><td>1/1</td></tr>
        <tr><td style="font-weight:bold">Nama Guru</td><td>Ustadzah Siti Rahmah</td><td style="font-weight:bold">Kelas/Usia</td><td>A / 5-6 Tahun</td></tr>
        <tr><td style="font-weight:bold">Tema</td><td>Aku, Makhluq Allah</td><td style="font-weight:bold">Sub Tema</td><td>Allah Tuhanku</td></tr>
        <tr><td style="font-weight:bold">Model</td><td colspan="3">Berbasis Proyek</td></tr>
        <tr><td style="font-weight:bold">Tujuan</td><td colspan="3">Anak dapat mengenal Allah sebagai Tuhan melalui kegiatan kreatif</td></tr>
        <tr><td style="font-weight:bold">Capaian</td><td colspan="3">Anak mampu menyebut nama Allah dan memahami ciptaan-Nya</td></tr>
      </table>
      <table class="prt">
        <thead><tr><th>Hari</th><th>Kegiatan</th><th>Bentuk</th><th>Aspek</th><th>Alat & Bahan</th></tr></thead>
        <tbody>
          <tr><td style="text-align:center;font-weight:bold">Senin</td><td>Kolase Tulisan "Terima Kasih Ya Allah"</td><td>Kolase</td><td>Nilai Agama, Seni</td><td>Kertas Origami, Lem, Gunting</td></tr>
          <tr><td style="text-align:center;font-weight:bold">Selasa</td><td>Menebalkan Nama Sendiri</td><td>Menggambar</td><td>Kognitif, Bahasa, Fisik Motorik</td><td>LKA, Pensil</td></tr>
        </tbody>
      </table>
      <div class="sgn">
        <div><div>Mengetahui,<br><strong>Kepala Sekolah</strong></div><div class="sn">Ustadzah Aminah, S.Pd.</div></div>
        <div><div>Serang, ___________<br><strong>Guru Kelas A</strong></div><div class="sn">Ustadzah Siti Rahmah</div></div>
      </div>
    </div>
  </div>
  <div class="mf"><button class="btn bo">Tutup</button><button class="btn bp">🖨️ Cetak</button></div>
</div></div>

<!-- Modal Data Sekolah -->
<div class="mo" id="mSek"><div class="md mmd">
  <div class="mh"><div><div class="mt2">🏫 Edit Data Sekolah</div></div><button class="mc">✕</button></div>
  <div class="mb">
    <div class="fr c2"><div class="ff"><label>Nama Sekolah</label><input value="PAUDQu AL-AULIA"/></div><div class="ff"><label>NPSN</label><input value="69990123"/></div></div>
    <div class="ff mb16"><label>Alamat</label><textarea rows="2">Jl. Al-Quran No.12, Serang, Banten</textarea></div>
    <div class="fr c2"><div class="ff"><label>Kepala Sekolah</label><input value="Ustadzah Aminah, S.Pd."/></div><div class="ff"><label>Telepon</label><input value="0812-3456-7890"/></div></div>
    <div class="fr c2"><div class="ff"><label>Tahun Ajaran</label><input value="2024/2025"/></div>
      <div class="ff"><label>Semester Aktif</label><select><option value="1">Semester 1</option><option value="2">Semester 2</option></select></div></div>
  </div>
  <div class="mf"><button class="btn bo">Batal</button><button class="btn bp">💾 Simpan</button></div>
</div></div>

<div id="toast" style="position:fixed;bottom:20px;right:20px;z-index:9999;background:var(--g7);color:var(--white);padding:12px 16px;border-radius:var(--r2);font-size:13px;font-weight:600;box-shadow:0 6px 24px rgba(0,0,0,.14);display:none">✅ Data berhasil disimpan</div>

<!-- Minimal JS hanya untuk navigasi halaman dan sidebar active -->
<script>
// Navigasi halaman via sidebar links
document.querySelectorAll('.sb a.ni').forEach(function(link) {
  link.addEventListener('click', function(e) {
    e.preventDefault();
    var target = this.getAttribute('href').replace('#', '');
    // Update active nav
    document.querySelectorAll('.sb a.ni').forEach(function(n) { n.classList.remove('on'); });
    this.classList.add('on');
    // Sembunyikan semua halaman
    document.querySelectorAll('.ca.pg').forEach(function(p) { p.classList.remove('on'); });
    // Tampilkan halaman target
    var page = document.getElementById(target);
    if (page) page.classList.add('on');
    // Update judul topbar
    var titles = {
      'beranda':'Beranda','pengguna':'Kelola Pengguna','siswa':'Data Siswa',
      'ta':'Tahun Ajaran','sekolah':'Data Sekolah','prosem':'Program Semester (PROSEM)',
      'tema':'Kelola Tema','master':'Master Bentuk & Alat','vrppm':'Validasi RPP',
      'vrpph':'Validasi RPPH','vkeg':'Validasi Kumpulan Kegiatan','monitoring':'Monitoring Guru',
      'keg':'Kumpulan Kegiatan','rppm':'Buat & Kelola RPP','rpph':'Buat & Kelola RPPH',
      'porto':'Portofolio Siswa','analisis':'Analisis Aspek Perkembangan',
      'ortu-rppm':'Lihat RPP','ortu-rpph':'Lihat RPPH','ortu-porto':'Portofolio Anak'
    };
    var t = document.getElementById('pageTitle');
    if (t) t.textContent = titles[target] || target;
  });
});
// Login page ke app
document.querySelector('.btn-login').addEventListener('click', function() {
  document.getElementById('lp').style.display = 'none';
  document.getElementById('app').style.display = 'block';
});
// Demo buttons
document.querySelectorAll('.db').forEach(function(btn) {
  btn.addEventListener('click', function() {
    document.getElementById('lp').style.display = 'none';
    document.getElementById('app').style.display = 'block';
  });
});
</script>

</body>
</html>