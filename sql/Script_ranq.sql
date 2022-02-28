// Soma de pontos por Vitorias e Empates

SELECT j.jogadorNome, SUM(tp.ponto) as TotalPontos FROM timepartida tp 

INNER JOIN partida p 
ON (tp.partidaId = p.partidaId) 

INNER JOIN jogadorpartida jp 
ON (p.partidaId = jp.partidaId) 

INNER JOIN jogador j 
ON (jp.jogadorId = j.jogadorId)

GROUP BY j.jogadorId
ORDER BY TotalPontos DESC;



// Soma de Total de Gols

SELECT j.jogadorNome, SUM(jp.gol) as TotalGol FROM jogadorpartida jp

INNER JOIN jogador j
ON (jp.jogadorId = j.jogadorId)

GROUP BY j.jogadorId
ORDER BY TotalGol DESC;

SELECT SUM(p.golAzul) as golAzul, SUM(p.golBranco) as golBranco, p.partidaId, p.nPartida FROM partida

INNER JOIN jogadorpartida jp
ON (jp.partidaId = p.partidaId)





// Soma Total de Vitorias

SELECT j.jogadorNome, COUNT(tp.timepartidaId) as Vitorias, SUM(tp.ponto) as TotalPontos FROM timepartida tp
	INNER JOIN jogadorpartida jp
    ON tp.partidaId = jp.partidaId AND tp.timeId = jp.timeId
    	INNER JOIN jogador j
        ON jp.jogadorId = j.jogadorId
WHERE vitoriaEmpate = 1
GROUP BY j.jogadorId
ORDER BY TotalPontos DESC;


// Soma total Empates

SELECT j.jogadorNome, COUNT(tp.timepartidaId) as Empates, SUM(tp.ponto) as TotalPontos FROM timepartida tp
	INNER JOIN jogadorpartida jp
    ON tp.partidaId = jp.partidaId
    	INNER JOIN jogador j
        ON jp.jogadorId = j.jogadorId
WHERE vitoriaEmpate = 0
GROUP BY j.jogadorId
ORDER BY TotalPontos DESC;




SELECT j.jogadornome, (SELECT SUM(tp.ponto) as TotalPontosV FROM timepartida tp
                INNER JOIN jogadorpartida jp
                ON tp.partidaId = jp.partidaId AND tp.timeId = jp.timeId
                    INNER JOIN jogador j
                    ON jp.jogadorId = j.jogadorId
        WHERE vitoriaEmpate = 1
        AND j.jogadorId IN (9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25)    
        GROUP BY j.jogadorId
        ORDER BY TotalPontosV DESC )
+
		(SELECT SUM(tp.ponto) as TotalPontosV FROM timepartida tp
                INNER JOIN jogadorpartida jp
                ON tp.partidaId = jp.partidaId
                    INNER JOIN jogador j
                    ON jp.jogadorId = j.jogadorId
        WHERE vitoriaEmpate = 0
        AND j.jogadorId IN (9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25)    
        GROUP BY j.jogadorId
        ORDER BY TotalPontosV DESC ) as TotalPontos
            
FROM timepartida tp 

INNER JOIN partida p 
ON (tp.partidaId = p.partidaId) 

INNER JOIN jogadorpartida jp 
ON (p.partidaId = jp.partidaId AND jp.timeId = 0) 

INNER JOIN jogador j 
ON (jp.jogadorId = j.jogadorId)

GROUP BY j.jogadorId
ORDER BY TotalPontos DESC;


9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25