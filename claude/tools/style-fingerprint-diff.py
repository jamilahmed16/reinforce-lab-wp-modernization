import json,sys
a=json.load(open(sys.argv[1])); b=json.load(open(sys.argv[2]))
tot=0
for k in a:
    if k not in b: print(k,'missing'); continue
    A,B=a[k],b[k]
    if len(A)!=len(B): print(k,'count',len(A),len(B))
    n=0
    for x,y in zip(A,B):
        if x[1]!=y[1] or x[2]!=y[2] or x[3]!=y[3]:
            n+=1
            if n<=6:
                print(' ',k,x[1][:40])
                if x[2]!=y[2]:
                    pa=x[2].split('|');pb=y[2].split('|')
                    for i,(p,q) in enumerate(zip(pa,pb)):
                        if p!=q: print('     prop',i,repr(p[:70]),'->',repr(q[:70]))
                if x[3]!=y[3]: print('     box',x[3],'->',y[3])
                if x[1]!=y[1]: print('     class',x[1][:60],'->',y[1][:60])
    print(k,'diffs',n); tot+=n
print('TOTAL',tot)
